// frontend/js/modules/map.js

export function initMap() {
    const mapModal = document.getElementById('map-modal');
    const showMapButton = document.getElementById('show-map');
    
    // Если элементов нет на этой странице, выходим
    if (!mapModal || !showMapButton) return;

    let map;
    let mapInitialized = false;
    
    const barCoordinates = [mapModal.dataset.latitude, mapModal.dataset.longitude];
    
    // Функция инициализации карты
    function initYandexMap() {
        if (mapInitialized) return;
        
        // Проверяем, загрузилась ли библиотека Yandex
        if (typeof ymaps === 'undefined') {
            console.error('Yandex Maps API не загружен');
            return;
        }

        ymaps.ready(function() {
            map = new ymaps.Map('modal-map-container', {
                center: barCoordinates,
                zoom: 16,
                controls: ['zoomControl', 'fullscreenControl']
            });
            
            const myPlacemark = new ymaps.Placemark(barCoordinates, {
                balloonContent: 'Бар "Пинта"<br>ул. Покровка, 15<br>Москва, 105062'
            }, {
                preset: 'islands#blueBeerIcon',
                iconColor: '#3a7bd5'
            });
            
            map.geoObjects.add(myPlacemark);
            mapInitialized = true;
        });
    }
    
    // Обработчики событий
    const closeMapModal = document.getElementById('close-map-modal');
    
    showMapButton.addEventListener('click', function(e) {
        e.preventDefault();
        mapModal.style.display = 'flex';
        
        if (!mapInitialized) {
            setTimeout(initYandexMap, 100);
        } else {
            map.container.fitToViewport();
        }
    });
    
    if (closeMapModal) {
        closeMapModal.addEventListener('click', function() {
            mapModal.style.display = 'none';
        });
    }
    
    mapModal.addEventListener('click', function(e) {
        if (e.target === mapModal) {
            mapModal.style.display = 'none';
        }
    });
    
    window.addEventListener('resize', function() {
        if (mapInitialized && mapModal.style.display === 'flex') {
            setTimeout(() => {
                map.container.fitToViewport();
            }, 200);
        }
    });
}