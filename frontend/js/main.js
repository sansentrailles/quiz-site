// frontend/js/main.js

import { initCommon } from './modules/common';
import { initMap } from './modules/map';
import { initBooking } from './modules/booking';
import { initQuiz } from './modules/quiz';
import { Navigator } from './modules/navigator';

// Используем одно событие DOMContentLoaded для запуска всего
document.addEventListener('DOMContentLoaded', function() {
    // Инициализируем общие скрипты
    initCommon();
    
    // Инициализируем карту
    initMap();

    // страница квиза
    initQuiz();

    // Форма записи
    initBooking();

    // Навигатор
    const navEl = document.getElementById('navigator');
    if (navEl) {
        new Navigator(navEl);
    }
});
