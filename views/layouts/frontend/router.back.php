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

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-user-select: none;
            user-select: none;
        }

        html, body {
            width: 100%;
            height: 100%;
            overflow: hidden;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            background: radial-gradient(circle at center, #1a1f3a 0%, #0a0e1f 100%);
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            padding: 30px 20px;
            position: relative;
            transition: background 0.6s ease;
        }

        body.arrived {
            background: radial-gradient(circle at center, #1a3a2a 0%, #0a1f14 100%);
        }

        /* Фоновые звёзды */
        .stars {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            pointer-events: none;
            opacity: 0.4;
        }

        .top-panel {
            text-align: center;
            z-index: 2;
            width: 100%;
        }

        .title {
            font-size: 1.1em;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #8a94c7;
            margin-bottom: 15px;
            transition: color 0.6s ease;
        }

        body.arrived .title {
            color: #86efac;
        }

        .distance {
            font-size: 4em;
            font-weight: 200;
            line-height: 1;
            background: linear-gradient(135deg, #ffffff 0%, #6ea8ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 0 40px rgba(110, 168, 255, 0.3);
            transition: all 0.6s ease;
        }

        body.arrived .distance {
            background: linear-gradient(135deg, #ffffff 0%, #4ade80 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: arrivedPulse 2s ease-in-out infinite;
        }

        @keyframes arrivedPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .distance-unit {
            font-size: 0.35em;
            color: #8a94c7;
            margin-left: 5px;
            vertical-align: middle;
        }

        .coords {
            margin-top: 15px;
            font-size: 0.85em;
            color: #6ea8ff;
            font-family: 'Courier New', monospace;
            letter-spacing: 1px;
        }

        /* Контейнер стрелки */
        .compass-container {
            position: relative;
            width: min(85vw, 85vh, 500px);
            height: min(85vw, 85vh, 500px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
        }

        /* Внешнее кольцо */
        .compass-ring {
            position: absolute;
            width: 100%;
            height: 100%;
            border: 2px solid rgba(110, 168, 255, 0.2);
            border-radius: 50%;
            box-shadow: 
                0 0 60px rgba(110, 168, 255, 0.15) inset,
                0 0 40px rgba(110, 168, 255, 0.1);
            transition: all 0.6s ease;
        }

        body.arrived .compass-ring {
            border-color: rgba(74, 222, 128, 0.4);
            box-shadow: 
                0 0 60px rgba(74, 222, 128, 0.25) inset,
                0 0 40px rgba(74, 222, 128, 0.2);
        }

        .compass-ring::before {
            content: '';
            position: absolute;
            top: -2px; left: -2px; right: -2px; bottom: -2px;
            border: 1px dashed rgba(110, 168, 255, 0.3);
            border-radius: 50%;
            animation: rotate 60s linear infinite;
            transition: border-color 0.6s ease;
        }

        body.arrived .compass-ring::before {
            border-color: rgba(74, 222, 128, 0.4);
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Метки N/E/S/W */
        .cardinal {
            position: absolute;
            font-size: 1.2em;
            font-weight: 600;
            color: #8a94c7;
            letter-spacing: 2px;
            transition: color 0.6s ease;
        }
        body.arrived .cardinal {
            color: #86efac;
        }
        .cardinal.n { top: 10px; left: 50%; transform: translateX(-50%); }
        .cardinal.s { bottom: 10px; left: 50%; transform: translateX(-50%); }
        .cardinal.e { right: 15px; top: 50%; transform: translateY(-50%); }
        .cardinal.w { left: 15px; top: 50%; transform: translateY(-50%); }

        /* Стрелка */
        .arrow-wrapper {
            width: 70%;
            height: 70%;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: transform;
        }

        .arrow-svg {
            width: 100%;
            height: 100%;
            filter: drop-shadow(0 0 20px rgba(255, 100, 100, 0.6));
            transition: filter 0.6s ease;
        }

        body.arrived .arrow-svg {
            filter: drop-shadow(0 0 25px rgba(74, 222, 128, 0.8));
            animation: arrowPulse 1.5s ease-in-out infinite;
        }

        @keyframes arrowPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.08); }
        }

        /* Центральная точка */
        .center-dot {
            position: absolute;
            width: 14px;
            height: 14px;
            background: white;
            border-radius: 50%;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.8);
        }

        /* Нижняя панель */
        .bottom-panel {
            text-align: center;
            z-index: 2;
            width: 100%;
        }

        .status {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px 20px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(110, 168, 255, 0.2);
            border-radius: 30px;
            backdrop-filter: blur(10px);
            margin: 0 auto;
            width: fit-content;
            max-width: 100%;
            transition: all 0.6s ease;
        }

        body.arrived .status {
            border-color: rgba(74, 222, 128, 0.4);
            background: rgba(74, 222, 128, 0.1);
        }

        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #4ade80;
            box-shadow: 0 0 10px #4ade80;
            animation: pulse 2s infinite;
        }

        .status-dot.error {
            background: #f87171;
            box-shadow: 0 0 10px #f87171;
            animation: none;
        }

        .status-dot.pending {
            background: #fbbf24;
            box-shadow: 0 0 10px #fbbf24;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }

        .status-text {
            font-size: 0.9em;
            color: #c7d0f0;
        }

        .heading-info {
            margin-top: 12px;
            font-size: 0.8em;
            color: #6ea8ff;
            font-family: 'Courier New', monospace;
        }

        /* Кнопка запроса разрешения */
        .permission-overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(10, 14, 31, 0.95);
            backdrop-filter: blur(10px);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 100;
            padding: 30px;
            text-align: center;
        }

        .permission-overlay.hidden {
            display: none;
        }

        .permission-title {
            font-size: 1.8em;
            margin-bottom: 15px;
            background: linear-gradient(135deg, #ffffff 0%, #6ea8ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .permission-text {
            color: #8a94c7;
            margin-bottom: 30px;
            line-height: 1.6;
            max-width: 400px;
        }

        .permission-btn {
            padding: 15px 40px;
            background: linear-gradient(135deg, #6ea8ff 0%, #4f7cff 100%);
            color: white;
            border: none;
            border-radius: 30px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            letter-spacing: 1px;
            box-shadow: 0 10px 30px rgba(79, 124, 255, 0.4);
            transition: transform 0.2s;
        }

        .permission-btn:active {
            transform: scale(0.95);
        }

        .target-info {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 0.7em;
            color: #6ea8ff;
            text-align: right;
            z-index: 3;
            opacity: 0.7;
        }

        /* ====== Модалка достижения цели ====== */
        .arrival-overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(10, 31, 20, 0.85);
            backdrop-filter: blur(15px);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 200;
            padding: 30px;
            text-align: center;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.5s ease;
        }

        .arrival-overlay.visible {
            opacity: 1;
            pointer-events: auto;
        }

        .arrival-icon {
            font-size: 5em;
            margin-bottom: 20px;
            animation: bounce 1.5s ease-in-out infinite;
            filter: drop-shadow(0 0 30px rgba(74, 222, 128, 0.6));
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        .arrival-title {
            font-size: 2.2em;
            font-weight: 700;
            margin-bottom: 15px;
            background: linear-gradient(135deg, #ffffff 0%, #4ade80 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: 2px;
        }

        .arrival-subtitle {
            color: #a7f3d0;
            font-size: 1.1em;
            margin-bottom: 30px;
            line-height: 1.6;
            max-width: 400px;
        }

        .arrival-stats {
            background: rgba(74, 222, 128, 0.1);
            border: 1px solid rgba(74, 222, 128, 0.3);
            border-radius: 15px;
            padding: 20px 30px;
            margin-bottom: 30px;
            min-width: 250px;
        }

        .arrival-stat-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            font-size: 0.95em;
        }

        .arrival-stat-row + .arrival-stat-row {
            border-top: 1px solid rgba(74, 222, 128, 0.15);
        }

        .arrival-stat-label {
            color: #86efac;
            opacity: 0.8;
        }

        .arrival-stat-value {
            color: white;
            font-weight: 600;
            font-family: 'Courier New', monospace;
        }

        .arrival-btn {
            padding: 15px 40px;
            background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%);
            color: white;
            border: none;
            border-radius: 30px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            letter-spacing: 1px;
            box-shadow: 0 10px 30px rgba(74, 222, 128, 0.4);
            transition: transform 0.2s;
        }

        .arrival-btn:active {
            transform: scale(0.95);
        }

        /* Конфетти-частицы при достижении */
        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            pointer-events: none;
            animation: confettiFall 3s linear forwards;
        }

        @keyframes confettiFall {
            0% {
                transform: translateY(-100vh) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(100vh) rotate(720deg);
                opacity: 0;
            }
        }
    </style>

    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody(); ?>
        <?php echo $content; ?>

        <script>
            // ============================================================
            // 🎯 КООРДИНАТЫ ЦЕЛЕВОЙ ТОЧКИ
            // ============================================================
            const TARGET_LAT = 55.7558;   // Широта цели
            const TARGET_LNG = 37.6176;   // Долгота цел
            const TARGET_NAME = "Цель";
            
            // 🎯 ПОГРЕШНОСТЬ ДОСТИЖЕНИЯ ЦЕЛИ (в метрах)
            // Точка считается достигнутой, если расстояние до неё меньше этого значения
            const ARRIVAL_RADIUS = 30;
            // ============================================================

            // Отображение информации о цели
            document.getElementById('targetInfo').innerHTML = 
                `ЦЕЛЬ<br>${TARGET_LAT.toFixed(4)}°N<br>${TARGET_LNG.toFixed(4)}°E<br>±${ARRIVAL_RADIUS}м`;

            // ====== Фильтр Калмана ======
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
                    const prediction = this.estimate;
                    const predictionError = this.errorCovariance + this.processNoise;
                    const kalmanGain = predictionError / (predictionError + this.measurementNoise);
                    this.estimate = prediction + kalmanGain * (measurement - prediction);
                    this.errorCovariance = (1 - kalmanGain) * predictionError;
                    return this.estimate;
                }
            }

            // Фильтр для углов (учитывает цикличность 0-360)
            class AngleFilter {
                constructor(smoothing = 0.3) {
                    this.smoothing = smoothing;
                    this.angle = null;
                }
                filter(newAngle) {
                    if (this.angle === null) {
                        this.angle = newAngle;
                        return this.angle;
                    }
                    let diff = newAngle - this.angle;
                    while (diff > 180) diff -= 360;
                    while (diff < -180) diff += 360;
                    this.angle = this.angle + diff * this.smoothing;
                    while (this.angle < 0) this.angle += 360;
                    while (this.angle >= 360) this.angle -= 360;
                    return this.angle;
                }
            }

            // ====== Утилиты ======
            function calculateDistance(lat1, lng1, lat2, lng2) {
                const R = 6371000;
                const dLat = (lat2 - lat1) * Math.PI / 180;
                const dLng = (lng2 - lng1) * Math.PI / 180;
                const a = Math.sin(dLat / 2) ** 2 +
                        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                        Math.sin(dLng / 2) ** 2;
                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                return R * c;
            }

            function calculateBearing(lat1, lng1, lat2, lng2) {
                const φ1 = lat1 * Math.PI / 180;
                const φ2 = lat2 * Math.PI / 180;
                const Δλ = (lng2 - lng1) * Math.PI / 180;
                const y = Math.sin(Δλ) * Math.cos(φ2);
                const x = Math.cos(φ1) * Math.sin(φ2) -
                        Math.sin(φ1) * Math.cos(φ2) * Math.cos(Δλ);
                let θ = Math.atan2(y, x);
                θ = θ * 180 / Math.PI;
                return (θ + 360) % 360;
            }

            function formatTime(date) {
                return date.toLocaleTimeString('ru-RU', { 
                    hour: '2-digit', 
                    minute: '2-digit', 
                    second: '2-digit' 
                });
            }

            // ====== Состояние ======
            let currentLat = null;
            let currentLng = null;
            let currentHeading = null;
            let currentAccuracy = null;
            let gpsReady = false;
            let headingReady = false;
            let hasArrived = false;         // Флаг: цель достигнута (чтобы не показывать модалку повторно)
            let arrivalDismissed = false;   // Флаг: пользователь закрыл модалку
            let startTime = Date.now();

            // Фильтры
            const latFilter = new KalmanFilter(0.00001, 0.0005);
            const lngFilter = new KalmanFilter(0.00001, 0.0005);
            const headingFilter = new AngleFilter(0.25);

            // ====== DOM элементы ======
            const arrowWrapper = document.getElementById('arrowWrapper');
            const distanceValue = document.getElementById('distanceValue');
            const distanceUnit = document.getElementById('distanceUnit');
            const coordsDisplay = document.getElementById('coordsDisplay');
            const headingInfo = document.getElementById('headingInfo');
            const statusDot = document.getElementById('statusDot');
            const statusText = document.getElementById('statusText');
            const permissionOverlay = document.getElementById('permissionOverlay');
            const startBtn = document.getElementById('startBtn');
            const arrivalOverlay = document.getElementById('arrivalOverlay');
            const arrivalBtn = document.getElementById('arrivalBtn');
            const arrivalDistance = document.getElementById('arrivalDistance');
            const arrivalAccuracy = document.getElementById('arrivalAccuracy');
            const arrivalTime = document.getElementById('arrivalTime');

            // ====== Конфетти при достижении ======
            function spawnConfetti() {
                const colors = ['#4ade80', '#22c55e', '#86efac', '#ffffff', '#fbbf24'];
                for (let i = 0; i < 40; i++) {
                    const confetti = document.createElement('div');
                    confetti.className = 'confetti';
                    confetti.style.left = Math.random() * 100 + '%';
                    confetti.style.background = colors[Math.floor(Math.random() * colors.length)];
                    confetti.style.animationDelay = (Math.random() * 1.5) + 's';
                    confetti.style.animationDuration = (2 + Math.random() * 2) + 's';
                    confetti.style.width = (6 + Math.random() * 8) + 'px';
                    confetti.style.height = confetti.style.width;
                    confetti.style.borderRadius = Math.random() > 0.5 ? '50%' : '2px';
                    arrivalOverlay.appendChild(confetti);
                    
                    setTimeout(() => confetti.remove(), 4500);
                }
            }

            // ====== Показ модалки достижения ======
            function showArrivalModal(distance) {
                arrivalDistance.textContent = distance.toFixed(1) + ' м';
                arrivalAccuracy.textContent = currentAccuracy ? currentAccuracy.toFixed(1) + ' м' : '—';
                arrivalTime.textContent = formatTime(new Date());
                arrivalOverlay.classList.add('visible');
                spawnConfetti();
            }

            function hideArrivalModal() {
                arrivalOverlay.classList.remove('visible');
                arrivalDismissed = true;
            }

            arrivalBtn.addEventListener('click', hideArrivalModal);

            // ====== Проверка достижения цели ======
            function checkArrival(distance) {
                const isArrived = distance <= ARRIVAL_RADIUS;

                if (isArrived && !hasArrived) {
                    // Только что достигли цели — показываем модалку
                    hasArrived = true;
                    arrivalDismissed = false;
                    document.body.classList.add('arrived');
                    showArrivalModal(distance);
                    
                    // Вибрация устройства (если поддерживается)
                    if (navigator.vibrate) {
                        navigator.vibrate([200, 100, 200, 100, 400]);
                    }
                } else if (!isArrived && hasArrived) {
                    // Покинули зону достижения — сбрасываем состояние
                    hasArrived = false;
                    arrivalDismissed = false;
                    document.body.classList.remove('arrived');
                    arrivalOverlay.classList.remove('visible');
                }
            }

            // ====== Обновление UI ======
            function updateUI() {
                if (currentLat === null || currentLng === null) return;

                // Расстояние
                const distance = calculateDistance(currentLat, currentLng, TARGET_LAT, TARGET_LNG);
                if (distance >= 1000) {
                    distanceValue.textContent = (distance / 1000).toFixed(2);
                    distanceUnit.textContent = 'км';
                } else {
                    distanceValue.textContent = Math.round(distance);
                    distanceUnit.textContent = 'м';
                }

                // Координаты
                coordsDisplay.textContent = `${currentLat.toFixed(6)}°, ${currentLng.toFixed(6)}°`;

                // Поворот стрелки
                if (currentHeading !== null) {
                    const bearing = calculateBearing(currentLat, currentLng, TARGET_LAT, TARGET_LNG);
                    let arrowAngle = bearing - currentHeading;
                    while (arrowAngle > 180) arrowAngle -= 360;
                    while (arrowAngle < -180) arrowAngle += 360;
                    
                    arrowWrapper.style.transform = `rotate(${arrowAngle}deg)`;
                    
                    headingInfo.textContent = 
                        `Курс: ${Math.round(currentHeading)}° | Азимут: ${Math.round(bearing)}° | Δ: ${Math.round(arrowAngle)}°`;
                } else {
                    headingInfo.textContent = 'Курс: ожидание компаса...';
                }

                // Проверка достижения цели
                checkArrival(distance);

                // Обновляем статус
                updateStatus();
            }

            function updateStatus() {
                if (hasArrived) {
                    statusDot.className = 'status-dot';
                    statusText.textContent = `✓ Цель достигнута (±${ARRIVAL_RADIUS}м)`;
                    return;
                }
                if (!gpsReady && !headingReady) {
                    statusDot.className = 'status-dot pending';
                    statusText.textContent = 'Ожидание GPS и компаса...';
                } else if (gpsReady && !headingReady) {
                    statusDot.className = 'status-dot pending';
                    statusText.textContent = 'GPS ✓ | Ожидание компаса...';
                } else if (!gpsReady && headingReady) {
                    statusDot.className = 'status-dot pending';
                    statusText.textContent = 'Компас ✓ | Ожидание GPS...';
                } else {
                    statusDot.className = 'status-dot';
                    statusText.textContent = 'Наведение на цель';
                }
            }

            // ====== Обработка GPS ======
            function handlePosition(position) {
                const rawLat = position.coords.latitude;
                const rawLng = position.coords.longitude;

                currentLat = latFilter.filter(rawLat);
                currentLng = lngFilter.filter(rawLng);
                currentAccuracy = position.coords.accuracy;
                gpsReady = true;

                updateUI();
            }

            function handleGeoError(error) {
                statusDot.className = 'status-dot error';
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        statusText.textContent = 'Доступ к геолокации запрещён';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        statusText.textContent = 'Геолокация недоступна';
                        break;
                    case error.TIMEOUT:
                        statusText.textContent = 'Таймаут GPS';
                        break;
                    default:
                        statusText.textContent = 'Ошибка GPS';
                }
            }

            // ====== Обработка ориентации (компаса) ======
            function handleOrientation(event) {
                let heading = null;

                if (event.webkitCompassHeading !== undefined) {
                    heading = event.webkitCompassHeading;
                } else if (event.alpha !== null) {
                    heading = (360 - event.alpha) % 360;
                }

                if (heading !== null && !isNaN(heading)) {
                    currentHeading = headingFilter.filter(heading);
                    headingReady = true;
                    updateUI();
                }
            }

            // ====== Запуск системы ======
            function startTracking() {
                if ('geolocation' in navigator) {
                    navigator.geolocation.watchPosition(
                        handlePosition,
                        handleGeoError,
                        {
                            enableHighAccuracy: true,
                            timeout: 15000,
                            maximumAge: 0
                        }
                    );
                } else {
                    statusDot.className = 'status-dot error';
                    statusText.textContent = 'Геолокация не поддерживается';
                    return;
                }

                if (typeof DeviceOrientationEvent !== 'undefined' && 
                    typeof DeviceOrientationEvent.requestPermission === 'function') {
                    DeviceOrientationEvent.requestPermission()
                        .then(response => {
                            if (response === 'granted') {
                                window.addEventListener('deviceorientation', handleOrientation, true);
                            } else {
                                statusDot.className = 'status-dot error';
                                statusText.textContent = 'Доступ к компасу запрещён';
                            }
                        })
                        .catch(err => {
                            statusDot.className = 'status-dot error';
                            statusText.textContent = 'Ошибка доступа к компасу';
                        });
                } else {
                    window.addEventListener('deviceorientationabsolute', handleOrientation, true);
                    window.addEventListener('deviceorientation', handleOrientation, true);
                }
            }

            // ====== Обработчик кнопки запуска ======
            startBtn.addEventListener('click', () => {
                permissionOverlay.classList.add('hidden');
                startTracking();
            });

            window.addEventListener('load', () => {
                const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) || 
                            (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1);
                const needsPermission = typeof DeviceOrientationEvent !== 'undefined' && 
                                    typeof DeviceOrientationEvent.requestPermission === 'function';
                
                if (!isIOS && !needsPermission) {
                    permissionOverlay.classList.add('hidden');
                    startTracking();
                }
            });

            let lastTouchEnd = 0;
            document.addEventListener('touchend', (event) => {
                const now = Date.now();
                if (now - lastTouchEnd <= 300) {
                    event.preventDefault();
                }
                lastTouchEnd = now;
            }, false);
        </script>
    <?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
