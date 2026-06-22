<!-- Фоновые звёзды -->
<svg class="stars" xmlns="http://www.w3.org/2000/svg">
    <defs>
        <pattern id="starfield" width="200" height="200" patternUnits="userSpaceOnUse">
            <circle cx="20" cy="30" r="0.8" fill="white"/>
            <circle cx="80" cy="60" r="0.5" fill="white"/>
            <circle cx="150" cy="20" r="1" fill="white"/>
            <circle cx="40" cy="120" r="0.6" fill="white"/>
            <circle cx="170" cy="150" r="0.7" fill="white"/>
            <circle cx="100" cy="180" r="0.5" fill="white"/>
            <circle cx="60" cy="90" r="0.4" fill="white"/>
            <circle cx="130" cy="100" r="0.8" fill="white"/>
        </pattern>
    </defs>
    <rect width="100%" height="100%" fill="url(#starfield)"/>
</svg>

<!-- Модалка достижения точки -->
<div class="arrival-overlay" id="arrivalOverlay">
    <div class="arrival-icon">🎯</div>
    <div class="arrival-title">ТОЧКА ДОСТИГНУТА!</div>
    <div class="arrival-point-name" id="arrivalPointName">КП2</div>
    <div class="arrival-message" id="arrivalMessage">Вы достигли точки Стелла</div>
    <div class="arrival-stats">
        <div class="arrival-stat-row">
            <span class="arrival-stat-label">Расстояние</span>
            <span class="arrival-stat-value" id="arrivalDistance">—</span>
        </div>
        <div class="arrival-stat-row">
            <span class="arrival-stat-label">Погрешность GPS</span>
            <span class="arrival-stat-value" id="arrivalAccuracy">—</span>
        </div>
        <div class="arrival-stat-row">
            <span class="arrival-stat-label">Время</span>
            <span class="arrival-stat-value" id="arrivalTime">—</span>
        </div>
    </div>
    <button class="arrival-btn" id="arrivalBtn">ПРОДОЛЖИТЬ</button>
</div>

<!-- Верхняя панель -->
<div class="top-panel">
    <div class="route-title" id="routeTitle">Маршрут</div>

    <!-- Блок "Следующая точка" — без рамки, название на одной строке -->
    <div class="current-target">
        <div class="current-target-row">
            <span class="current-target-label">Следующая точка:</span>
            <span class="current-target-name" id="currentTargetName">—</span>
        </div>
        <div class="distance">
            <span id="distanceValue">—</span>
            <span class="distance-unit" id="distanceUnit">м</span>
        </div>
    </div>

    <!-- Список точек — слева сверху, без рамок -->
    <div class="points-list" id="pointsList"></div>

    <div class="coords" id="coordsDisplay">Ожидание GPS...</div>
</div>

<!-- Компас -->
<div class="compass-container">
    <div class="compass-ring"></div>
    
    <div class="compass-cardinals" id="compassCardinals">
        <div class="cardinal n">N</div>
        <div class="cardinal s">S</div>
        <div class="cardinal e">E</div>
        <div class="cardinal w">W</div>
    </div>
    
    <div class="arrow-wrapper" id="arrowWrapper">
        <svg class="arrow-svg" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <linearGradient id="arrowGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" stop-color="#ff8a8a"/>
                    <stop offset="50%" stop-color="#ff4757"/>
                    <stop offset="100%" stop-color="#c44569"/>
                </linearGradient>
                <filter id="glow">
                    <feGaussianBlur stdDeviation="3" result="coloredBlur"/>
                    <feMerge>
                        <feMergeNode in="coloredBlur"/>
                        <feMergeNode in="SourceGraphic"/>
                    </feMerge>
                </filter>
            </defs>
            
            <path d="M 100 15 
                        L 70 115 
                        L 100 95 
                        L 130 115 
                        Z" 
                    fill="url(#arrowGradient)" 
                    stroke="#ffcccc" 
                    stroke-width="1.5" 
                    stroke-linejoin="round"
                    filter="url(#glow)"/>
            
            <line x1="100" y1="25" x2="100" y2="95" 
                    stroke="white" 
                    stroke-width="1.5" 
                    opacity="0.5"
                    stroke-linecap="round"/>
        </svg>
    </div>

    <div class="center-dot"></div>
</div>

<!-- Нижняя панель -->
<div class="bottom-panel">
    <div class="status">
        <div class="status-dot pending" id="statusDot"></div>
        <div class="status-text" id="statusText">Инициализация...</div>
    </div>
    <div class="heading-info" id="headingInfo">Курс: —° | Азимут: —°</div>
</div>