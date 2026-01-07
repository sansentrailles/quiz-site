document.addEventListener('DOMContentLoaded', function() {
    let map;
    let mapInitialized = false;
    
    const mapModal = document.getElementById('map-modal');

    
    // Координаты бара "Пинта" (ул. Покровка, 15, Москва)
    const barCoordinates = [mapModal.dataset.latitude, mapModal.dataset.longitude];
    
    // Функция инициализации карты
    function initMap() {
        if (mapInitialized) return;
        
        ymaps.ready(function() {
            // Создаем карту
            map = new ymaps.Map('modal-map-container', {
                center: barCoordinates,
                zoom: 16,
                controls: ['zoomControl', 'fullscreenControl']
            });
            
            // Создаем метку
            const myPlacemark = new ymaps.Placemark(barCoordinates, {
                balloonContent: 'Бар "Пинта"<br>ул. Покровка, 15<br>Москва, 105062'
            }, {
                preset: 'islands#blueBeerIcon',
                iconColor: '#3a7bd5'
            });
            
            // Добавляем метку на карту
            map.geoObjects.add(myPlacemark);
            
            // Открываем балун при клике на метку
            myPlacemark.events.add('click', function(e) {
                e.get('target').balloon.open();
            });
            
            mapInitialized = true;
        });
    }
    
    // Открытие модального окна с картой
    const showMapButton = document.getElementById('show-map');
    const closeMapModal = document.getElementById('close-map-modal');
    
    showMapButton.addEventListener('click', function(e) {
        e.preventDefault();
        mapModal.style.display = 'flex';
        
        // Инициализируем карту при первом открытии модального окна
        if (!mapInitialized) {
            setTimeout(initMap, 100); // Небольшая задержка для корректного отображения
        } else {
            // Если карта уже инициализирована, обновляем ее
            map.container.fitToViewport();
        }
    });
    
    // Закрытие модального окна с картой
    closeMapModal.addEventListener('click', function() {
        mapModal.style.display = 'none';
    });
    
    // Закрытие модального окна с картой при клике вне его
    mapModal.addEventListener('click', function(e) {
        if (e.target === mapModal) {
            mapModal.style.display = 'none';
        }
    });
    
    // Инициализация карты при изменении размеров окна
    window.addEventListener('resize', function() {
        if (mapInitialized && mapModal.style.display === 'flex') {
            setTimeout(() => {
                map.container.fitToViewport();
            }, 200);
        }
    });
});
