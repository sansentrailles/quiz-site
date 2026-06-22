<script>
        // ====== Загрузка данных из data-атрибута ======
        const routeData = JSON.parse(document.body.dataset.route);
        const points = routeData.points.map(p => ({
            latitude: parseFloat(p.latitude),
            longitude: parseFloat(p.longitude),
            title: p.title,
            message: p.message
        }));
        const arrivalRadius = routeData.arrival_radius || 30;
        const routeTitle = routeData.title || 'Маршрут';

        document.getElementById('routeTitle').textContent = routeTitle;

        let currentPointIndex = 0;

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
                hour: '2-digit', minute: '2-digit', second: '2-digit' 
            });
        }

        function formatDistance(dist) {
            return dist >= 1000 ? `${(dist/1000).toFixed(2)} км` : `${Math.round(dist)} м`;
        }

        // ====== Состояние ======
        let currentLat = null;
        let currentLng = null;
        let currentHeading = null;
        let currentAccuracy = null;
        let gpsReady = false;
        let headingReady = false;
        let hasArrived = false;
        let arrivalDismissed = false;

        const latFilter = new KalmanFilter(0.00001, 0.0005);
        const lngFilter = new KalmanFilter(0.00001, 0.0005);
        const headingFilter = new AngleFilter(0.25);

        // ====== DOM элементы ======
        const arrowWrapper = document.getElementById('arrowWrapper');
        const compassCardinals = document.getElementById('compassCardinals');
        const distanceValue = document.getElementById('distanceValue');
        const distanceUnit = document.getElementById('distanceUnit');
        const coordsDisplay = document.getElementById('coordsDisplay');
        const headingInfo = document.getElementById('headingInfo');
        const statusDot = document.getElementById('statusDot');
        const statusText = document.getElementById('statusText');
        const arrivalOverlay = document.getElementById('arrivalOverlay');
        const arrivalBtn = document.getElementById('arrivalBtn');
        const arrivalPointName = document.getElementById('arrivalPointName');
        const arrivalMessage = document.getElementById('arrivalMessage');
        const arrivalDistance = document.getElementById('arrivalDistance');
        const arrivalAccuracy = document.getElementById('arrivalAccuracy');
        const arrivalTime = document.getElementById('arrivalTime');
        const pointsList = document.getElementById('pointsList');
        const currentTargetName = document.getElementById('currentTargetName');

        // ====== Инициализация списка точек ======
        function initPointsList() {
            pointsList.innerHTML = '';
            points.forEach((point, index) => {
                const pointEl = document.createElement('div');
                pointEl.className = 'point-item';
                pointEl.id = `point-${index}`;
                pointEl.innerHTML = `
                    <span class="point-number">${index + 1}.</span>
                    <span class="point-title">${point.title}</span>
                    <span class="point-distance" id="point-dist-${index}">—</span>
                `;
                pointsList.appendChild(pointEl);
            });
            updatePointsList();
        }

        function updatePointsList() {
            points.forEach((point, index) => {
                const pointEl = document.getElementById(`point-${index}`);
                const distEl = document.getElementById(`point-dist-${index}`);
                
                pointEl.classList.remove('active', 'completed');
                
                if (index < currentPointIndex) {
                    pointEl.classList.add('completed');
                    distEl.textContent = '✓';
                } else if (index === currentPointIndex) {
                    pointEl.classList.add('active');
                    if (currentLat !== null) {
                        const dist = calculateDistance(currentLat, currentLng, point.latitude, point.longitude);
                        distEl.textContent = formatDistance(dist);
                    }
                } else {
                    distEl.textContent = '—';
                }
            });

            currentTargetName.textContent = points[currentPointIndex].title;
        }

        // ====== Конфетти ======
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

        // ====== Показ модалки ======
        function showArrivalModal(distance) {
            const currentPoint = points[currentPointIndex];
            arrivalPointName.textContent = currentPoint.title;
            arrivalMessage.textContent = currentPoint.message;
            arrivalDistance.textContent = distance.toFixed(1) + ' м';
            arrivalAccuracy.textContent = currentAccuracy ? currentAccuracy.toFixed(1) + ' м' : '—';
            arrivalTime.textContent = formatTime(new Date());
            
            const isLastPoint = currentPointIndex === points.length - 1;
            arrivalBtn.textContent = isLastPoint ? 'ЗАВЕРШИТЬ' : 'ПРОДОЛЖИТЬ';
            arrivalBtn.className = 'arrival-btn' + (isLastPoint ? ' finish' : '');
            
            arrivalOverlay.classList.add('visible');
            spawnConfetti();
        }

        function hideArrivalModal() {
            arrivalOverlay.classList.remove('visible');
            arrivalDismissed = true;
        }

        function goToNextPoint() {
            currentPointIndex++;
            hasArrived = false;
            arrivalDismissed = false;
            document.body.classList.remove('arrived');
            hideArrivalModal();
            updatePointsList();
        }

        arrivalBtn.addEventListener('click', () => {
            if (currentPointIndex < points.length - 1) {
                goToNextPoint();
            } else {
                hideArrivalModal();
                document.body.classList.remove('arrived');
                statusText.textContent = 'Маршрут завершен!';
                statusDot.className = 'status-dot';
            }
        });

        // ====== Проверка достижения ======
        function checkArrival(distance) {
            const isArrived = distance <= arrivalRadius;

            if (isArrived && !hasArrived) {
                hasArrived = true;
                arrivalDismissed = false;
                document.body.classList.add('arrived');
                showArrivalModal(distance);
                if (navigator.vibrate) navigator.vibrate([200, 100, 200, 100, 400]);
            } else if (!isArrived && hasArrived) {
                hasArrived = false;
                arrivalDismissed = false;
                document.body.classList.remove('arrived');
                arrivalOverlay.classList.remove('visible');
            }
        }

        // ====== Обновление UI ======
        function updateUI() {
            if (currentLat === null || currentLng === null) return;

            const currentPoint = points[currentPointIndex];
            const distance = calculateDistance(currentLat, currentLng, currentPoint.latitude, currentPoint.longitude);
            
            if (distance >= 1000) {
                distanceValue.textContent = (distance / 1000).toFixed(2);
                distanceUnit.textContent = 'км';
            } else {
                distanceValue.textContent = Math.round(distance);
                distanceUnit.textContent = 'м';
            }

            coordsDisplay.textContent = `${currentLat.toFixed(6)}°, ${currentLng.toFixed(6)}°`;

            if (currentHeading !== null) {
                compassCardinals.style.transform = `rotate(${-currentHeading}deg)`;
            }

            if (currentHeading !== null) {
                const bearing = calculateBearing(currentLat, currentLng, currentPoint.latitude, currentPoint.longitude);
                
                if (distance <= arrivalRadius) {
                    arrowWrapper.style.transform = `rotate(0deg)`;
                } else {
                    let arrowAngle = bearing - currentHeading;
                    while (arrowAngle > 180) arrowAngle -= 360;
                    while (arrowAngle < -180) arrowAngle += 360;
                    arrowWrapper.style.transform = `rotate(${arrowAngle}deg)`;
                }
                
                headingInfo.textContent = 
                    `Курс: ${Math.round(currentHeading)}° | Азимут: ${Math.round(bearing)}°`;
            } else {
                headingInfo.textContent = 'Курс: ожидание компаса...';
            }

            updatePointsList();
            checkArrival(distance);
            updateStatus();
        }

        function updateStatus() {
            if (hasArrived) {
                statusDot.className = 'status-dot';
                statusText.textContent = `✓ Точка "${points[currentPointIndex].title}" достигнута`;
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
                statusText.textContent = `Наведение на "${points[currentPointIndex].title}"`;
            }
        }

        // ====== GPS ======
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

        // ====== Компас ======
        let usingAbsoluteOrientation = false;
        let iosOrientationRequested = false;

        function handleOrientationAbsolute(event) {
            if (typeof event.alpha !== 'number') return;
            usingAbsoluteOrientation = true;
            let heading = (360 - event.alpha) % 360;
            if (!isNaN(heading)) {
                currentHeading = headingFilter.filter(heading);
                headingReady = true;
                updateUI();
            }
        }

        function handleOrientation(event) {
            let heading = null;

            if (typeof event.webkitCompassHeading === 'number') {
                heading = event.webkitCompassHeading;
            } else if (usingAbsoluteOrientation) {
                return;
            } else if (typeof event.alpha === 'number') {
                heading = (360 - event.alpha) % 360;
            }

            if (heading !== null && !isNaN(heading)) {
                currentHeading = headingFilter.filter(heading);
                headingReady = true;
                updateUI();
            }
        }

        // ====== Запуск отслеживания (сразу, без стартового экрана) ======
        function startTracking() {
            if ('geolocation' in navigator) {
                navigator.geolocation.watchPosition(
                    handlePosition,
                    handleGeoError,
                    { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 }
                );
            } else {
                statusDot.className = 'status-dot error';
                statusText.textContent = 'Геолокация не поддерживается';
                return;
            }

            // Подписка на события ориентации
            window.addEventListener('deviceorientationabsolute', handleOrientationAbsolute, true);
            window.addEventListener('deviceorientation', handleOrientation, true);

            // Для iOS 13+ нужен запрос разрешения — делаем это при первом взаимодействии
            if (typeof DeviceOrientationEvent !== 'undefined' && 
                typeof DeviceOrientationEvent.requestPermission === 'function') {
                const requestIOSPermission = () => {
                    if (iosOrientationRequested) return;
                    iosOrientationRequested = true;
                    DeviceOrientationEvent.requestPermission()
                        .then(response => {
                            if (response !== 'granted') {
                                statusDot.className = 'status-dot error';
                                statusText.textContent = 'Доступ к компасу запрещён';
                            }
                        })
                        .catch(() => {
                            statusDot.className = 'status-dot error';
                            statusText.textContent = 'Ошибка доступа к компасу';
                        });
                };
                // Запрос при первом клике/тапе
                document.addEventListener('click', requestIOSPermission, { once: true });
                document.addEventListener('touchstart', requestIOSPermission, { once: true });
            }
        }

        // Автозапуск при загрузке
        window.addEventListener('load', () => {
            initPointsList();
            startTracking();
        });

        // Предотвращение масштабирования двойным тапом
        let lastTouchEnd = 0;
        document.addEventListener('touchend', (event) => {
            const now = Date.now();
            if (now - lastTouchEnd <= 300) event.preventDefault();
            lastTouchEnd = now;
        }, false);
    </script>