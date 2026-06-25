export class Navigator {
    constructor(container) {
        this.container = container;
        this.data = JSON.parse(container.dataset.points);
        this.points = this.data.points;
        this.arrivalRadius = this.data.arrival_radius || 30;
        this.currentPointIndex = 0;
        this.watchId = null;
        this.userHeading = 0;
        this.targetBearing = 0;
        this.isActive = false;

        this.elements = {
            title: document.getElementById('navTitle'),
            distance: document.getElementById('navDistance'),
            compassRing: document.getElementById('compassRing'),
            arrowContainer: document.getElementById('arrowContainer'),
            targetName: document.getElementById('targetName'),
            pointsList: document.getElementById('navPoints'),
            arrivalModal: document.getElementById('arrivalModal'),
            arrivalTitle: document.getElementById('arrivalTitle'),
            arrivalMessage: document.getElementById('arrivalMessage'),
            continueBtn: document.getElementById('continueBtn'),
            startScreen: document.getElementById('startScreen'),
            startBtn: document.getElementById('startBtn'),
            navError: document.getElementById('navError'),
        };

        this.filterState = {
            lat: null,
            lng: null,
            heading: null,
            alpha: 0.15,
        };

        this.renderPointsList();
        this.bindEvents();
    }

    bindEvents() {
        this.elements.startBtn.addEventListener('click', () => this.start());
        this.elements.continueBtn.addEventListener('click', () => this.continue());
    }

    start() {
        if (!navigator.geolocation) {
            this.showError('Геолокация не поддерживается вашим устройством');
            return;
        }

        this.elements.startScreen.style.display = 'none';
        this.isActive = true;
        this.updateCurrentTarget();
        this.renderPointsList();

        this.watchId = navigator.geolocation.watchPosition(
            (pos) => this.onPosition(pos),
            (err) => this.onError(err),
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0,
            }
        );

        if (window.DeviceOrientationEvent) {
            window.addEventListener('deviceorientationabsolute', (e) => this.onHeading(e));
            window.addEventListener('deviceorientation', (e) => this.onHeading(e));
        }
    }

    stop() {
        if (this.watchId !== null) {
            navigator.geolocation.clearWatch(this.watchId);
            this.watchId = null;
        }
        this.isActive = false;
    }

    smoothValue(current, newValue, alpha) {
        if (current === null) return newValue;
        return current + alpha * (newValue - current);
    }

    onPosition(position) {
        const { latitude, longitude } = position.coords;

        this.filterState.lat = this.smoothValue(this.filterState.lat, latitude, this.filterState.alpha);
        this.filterState.lng = this.smoothValue(this.filterState.lng, longitude, this.filterState.alpha);

        const userLat = this.filterState.lat;
        const userLng = this.filterState.lng;

        if (this.currentPointIndex >= this.points.length) {
            this.showAllReached();
            return;
        }

        const target = this.points[this.currentPointIndex];
        const targetLat = parseFloat(target.latitude);
        const targetLng = parseFloat(target.longitude);

        const distance = this.haversineDistance(userLat, userLng, targetLat, targetLng);
        this.elements.distance.textContent = distance < 1000
            ? `${Math.round(distance)} м`
            : `${(distance / 1000).toFixed(1)} км`;

        this.targetBearing = this.calculateBearing(userLat, userLng, targetLat, targetLng);
        this.updateArrow();

        if (distance <= this.arrivalRadius) {
            this.onArrival(target);
        }
    }

    onHeading(event) {
        let heading = null;

        if (event.webkitCompassHeading !== undefined) {
            heading = event.webkitCompassHeading;
        } else if (event.alpha !== null) {
            heading = (360 - event.alpha) % 360;
        }

        if (heading === null) return;

        this.userHeading = this.smoothValue(this.userHeading, heading, 0.2);
        this.updateArrow();
    }

    updateArrow() {
        if (!this.isActive) return;

        const rotation = this.targetBearing - this.userHeading;
        this.elements.arrowContainer.style.transform = `rotate(${rotation}deg)`;
        this.elements.compassRing.style.transform = `rotate(${-this.userHeading}deg)`;
    }

    haversineDistance(lat1, lon1, lat2, lon2) {
        const R = 6371000;
        const toRad = (deg) => (deg * Math.PI) / 180;
        const dLat = toRad(lat2 - lat1);
        const dLon = toRad(lon2 - lon1);
        const a =
            Math.sin(dLat / 2) ** 2 +
            Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) * Math.sin(dLon / 2) ** 2;
        return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    }

    calculateBearing(lat1, lon1, lat2, lon2) {
        const toRad = (deg) => (deg * Math.PI) / 180;
        const toDeg = (rad) => (rad * 180) / Math.PI;
        const dLon = toRad(lon2 - lon1);
        const y = Math.sin(dLon) * Math.cos(toRad(lat2));
        const x =
            Math.cos(toRad(lat1)) * Math.sin(toRad(lat2)) -
            Math.sin(toRad(lat1)) * Math.cos(toRad(lat2)) * Math.cos(dLon);
        return (toDeg(Math.atan2(y, x)) + 360) % 360;
    }

    onArrival(point) {
        this.stop();
        this.elements.arrivalTitle.textContent = point.title;
        this.elements.arrivalMessage.textContent = point.message;
        this.elements.arrivalModal.classList.add('navigator__modal--visible');

        const isLast = this.currentPointIndex >= this.points.length - 1;
        this.elements.continueBtn.textContent = isLast ? 'Завершить' : 'Продолжить';
        this.elements.continueBtn.dataset.isLast = isLast;
    }

    continue() {
        this.elements.arrivalModal.classList.remove('navigator__modal--visible');
        const isLast = this.elements.continueBtn.dataset.isLast === 'true';

        if (isLast) {
            this.showAllReached();
            return;
        }

        this.currentPointIndex++;
        this.updateCurrentTarget();
        this.renderPointsList();
        this.isActive = true;

        this.watchId = navigator.geolocation.watchPosition(
            (pos) => this.onPosition(pos),
            (err) => this.onError(err),
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0,
            }
        );
    }

    updateCurrentTarget() {
        if (this.currentPointIndex < this.points.length) {
            const target = this.points[this.currentPointIndex];
            this.elements.targetName.textContent = target.title;
            this.elements.title.textContent = this.data.title;
        }
    }

    renderPointsList() {
        this.elements.pointsList.innerHTML = this.points
            .map((point, i) => {
                let cls = 'navigator__point';
                if (i < this.currentPointIndex) cls += ' navigator__point--reached';
                else if (i === this.currentPointIndex) cls += ' navigator__point--active';
                return `<div class="${cls}">
                    <span class="navigator__point-marker">${i < this.currentPointIndex ? '✓' : i + 1}</span>
                    <span class="navigator__point-name">${point.title}</span>
                </div>`;
            })
            .join('');
    }

    showAllReached() {
        this.stop();
        this.elements.targetName.textContent = 'Маршрут завершён';
        this.elements.distance.textContent = '—';
        this.elements.arrowContainer.style.opacity = '0.3';
    }

    showError(msg) {
        this.elements.navError.textContent = msg;
        this.elements.navError.style.display = 'block';
    }

    onError(err) {
        const messages = {
            1: 'Доступ к геолокации запрещён',
            2: 'Информация о местоположении недоступна',
            3: 'Превышено время ожидания',
        };
        this.showError(messages[err.code] || 'Ошибка определения местоположения');
    }
}
