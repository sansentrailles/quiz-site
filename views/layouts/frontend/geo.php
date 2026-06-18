<?php

declare(strict_types=1);

use yii\helpers\Html;
use app\custom\helpers\AppHelper;

// @var $this \yii\web\View
// @var $content string


?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo Html::encode($this->title); ?></title>
    <?= Html::csrfMetaTags() ?>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            color: white;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .coords-panel {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .coords-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .coord-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            border-left: 4px solid #667eea;
        }

        .coord-label {
            font-size: 0.85em;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .coord-value {
            font-size: 1.5em;
            font-weight: bold;
            color: #333;
            font-family: 'Courier New', monospace;
        }

        .status {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 15px;
            background: #e7f3ff;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .status-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #28a745;
            animation: pulse 2s infinite;
        }

        .status-indicator.error {
            background: #dc3545;
            animation: none;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .status-text {
            color: #495057;
            font-weight: 500;
        }

        #map {
            height: 500px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .info-text {
            color: white;
            text-align: center;
            margin-top: 20px;
            font-size: 0.9em;
            opacity: 0.9;
        }
    </style>

    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody(); ?>
        <main class="container">
            <?php echo $content; ?>
        </main>

        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script>
            // Фильтр Калмана для одномерного случая
            class KalmanFilter {
                constructor(processNoise = 0.00001, measurementNoise = 0.001) {
                    this.processNoise = processNoise;
                    this.measurementNoise = measurementNoise;
                    this.estimate = null;
                    this.errorCovariance = 1;
                }

                filter(measurement) {
                    if (this.estimate === null) {
                        this.estimate = measurement;
                        return this.estimate;
                    }

                    // Prediction
                    const prediction = this.estimate;
                    const predictionError = this.errorCovariance + this.processNoise;

                    // Update
                    const kalmanGain = predictionError / (predictionError + this.measurementNoise);
                    this.estimate = prediction + kalmanGain * (measurement - prediction);
                    this.errorCovariance = (1 - kalmanGain) * predictionError;

                    return this.estimate;
                }
            }

            // Инициализация карты
            const map = L.map('map').setView([55.7558, 37.6176], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            let marker = null;
            let accuracyCircle = null;
            let path = L.polyline([], { color: '#667eea', weight: 3 }).addTo(map);

            // Фильтры для широты и долготы
            const latFilter = new KalmanFilter(0.00001, 0.001);
            const lngFilter = new KalmanFilter(0.00001, 0.001);

            // Элементы DOM
            const latitudeEl = document.getElementById('latitude');
            const longitudeEl = document.getElementById('longitude');
            const accuracyEl = document.getElementById('accuracy');
            const speedEl = document.getElementById('speed');
            const statusIndicator = document.getElementById('statusIndicator');
            const statusText = document.getElementById('statusText');

            // Обработка успешного получения координат
            function handlePosition(position) {
                const rawLat = position.coords.latitude;
                const rawLng = position.coords.longitude;
                const accuracy = position.coords.accuracy;
                const speed = position.coords.speed;

                // Применяем фильтр Калмана
                const filteredLat = latFilter.filter(rawLat);
                const filteredLng = lngFilter.filter(rawLng);

                // Обновляем отображение координат
                latitudeEl.textContent = filteredLat.toFixed(6);
                longitudeEl.textContent = filteredLng.toFixed(6);
                accuracyEl.textContent = accuracy.toFixed(1) + ' м';
                speedEl.textContent = speed ? (speed * 3.6).toFixed(1) + ' км/ч' : '0 км/ч';

                // Обновляем статус
                statusIndicator.classList.remove('error');
                statusText.textContent = 'GPS сигнал получен';

                // Обновляем маркер на карте
                if (marker) {
                    marker.setLatLng([filteredLat, filteredLng]);
                    accuracyCircle.setLatLng([filteredLat, filteredLng]);
                    accuracyCircle.setRadius(accuracy);
                } else {
                    marker = L.marker([filteredLat, filteredLng]).addTo(map);
                    marker.bindPopup('Ваше местоположение').openPopup();
                    
                    accuracyCircle = L.circle([filteredLat, filteredLng], {
                        radius: accuracy,
                        color: '#667eea',
                        fillColor: '#667eea',
                        fillOpacity: 0.1,
                        weight: 2
                    }).addTo(map);

                    map.setView([filteredLat, filteredLng], 16);
                }

                // Добавляем точку к пути
                path.addLatLng([filteredLat, filteredLng]);
            }

            // Обработка ошибок
            function handleError(error) {
                statusIndicator.classList.add('error');
                
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        statusText.textContent = 'Доступ к геолокации запрещен';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        statusText.textContent = 'Информация о местоположении недоступна';
                        break;
                    case error.TIMEOUT:
                        statusText.textContent = 'Истекло время ожидания запроса';
                        break;
                    default:
                        statusText.textContent = 'Произошла неизвестная ошибка';
                        break;
                }
            }

            // Проверка поддержки геолокации
            if ('geolocation' in navigator) {
                // Начинаем отслеживание с высокой точностью
                const watchId = navigator.geolocation.watchPosition(
                    handlePosition,
                    handleError,
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );

                statusText.textContent = 'Ожидание GPS сигнала...';
            } else {
                statusIndicator.classList.add('error');
                statusText.textContent = 'Геолокация не поддерживается браузером';
            }
        </script>
    <?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
