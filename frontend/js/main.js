// frontend/js/main.js

import { initCommon } from './modules/common';
import { initMap } from './modules/map';
import { initBooking } from './modules/booking';

// Используем одно событие DOMContentLoaded для запуска всего
document.addEventListener('DOMContentLoaded', function() {
    // Инициализируем общие скрипты
    initCommon();
    
    // Инициализируем карту
    initMap();

    // Форма записи
    initBooking();
    
    // В будущем здесь будут появляться новые импорты, например:
    // import { initSlider } from './modules/slider';
    // initSlider();
});
