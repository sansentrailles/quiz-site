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

<!-- Оверлей запроса разрешения (для iOS) -->
<div class="permission-overlay" id="permissionOverlay">
    <div class="permission-title">🧭 Компас к цели</div>
    <div class="permission-text">
        Для работы приложения требуется доступ к геолокации и датчикам ориентации устройства.
        <br><br>
        Нажмите кнопку ниже, чтобы начать.
    </div>
    <button class="permission-btn" id="startBtn">НАЧАТЬ</button>
</div>

<!-- Информация о цели -->
<div class="target-info" id="targetInfo"></div>

<!-- Верхняя панель с расстоянием -->
<div class="top-panel">
    <div class="title">Расстояние до цели</div>
    <div class="distance">
        <span id="distanceValue">—</span>
        <span class="distance-unit" id="distanceUnit">м</span>
    </div>
    <div class="coords" id="coordsDisplay">Ожидание GPS...</div>
</div>

<!-- Компас со стрелкой -->
<div class="compass-container">
    <div class="compass-ring"></div>
    <div class="cardinal n">N</div>
    <div class="cardinal s">S</div>
    <div class="cardinal e">E</div>
    <div class="cardinal w">W</div>
    
    <div class="arrow-wrapper" id="arrowWrapper">
        <svg class="arrow-svg" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <linearGradient id="arrowGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" stop-color="#ff6b6b"/>
                    <stop offset="50%" stop-color="#ff4757"/>
                    <stop offset="100%" stop-color="#c44569"/>
                </linearGradient>
                <linearGradient id="arrowTailGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" stop-color="#4a5580"/>
                    <stop offset="100%" stop-color="#2d3561"/>
                </linearGradient>
                <filter id="glow">
                    <feGaussianBlur stdDeviation="3" result="coloredBlur"/>
                    <feMerge>
                        <feMergeNode in="coloredBlur"/>
                        <feMergeNode in="SourceGraphic"/>
                    </feMerge>
                </filter>
            </defs>
            
            <!-- Хвост стрелки (серый) -->
            <path d="M 100 100 L 85 180 L 100 165 L 115 180 Z" 
                    fill="url(#arrowTailGradient)" 
                    stroke="#6ea8ff" 
                    stroke-width="1" 
                    opacity="0.8"/>
            
            <!-- Наконечник стрелки (красный, указывает вверх = к цели) -->
            <path d="M 100 15 L 75 100 L 100 85 L 125 100 Z" 
                    fill="url(#arrowGradient)" 
                    stroke="#ff9999" 
                    stroke-width="1.5" 
                    filter="url(#glow)"/>
            
            <!-- Центральная линия -->
            <line x1="100" y1="20" x2="100" y2="175" 
                    stroke="white" 
                    stroke-width="1" 
                    opacity="0.3"/>
        </svg>
    </div>

    <div class="center-dot"></div>
</div>

<!-- Нижняя панель со статусом -->
<div class="bottom-panel">
    <div class="status">
        <div class="status-dot pending" id="statusDot"></div>
        <div class="status-text" id="statusText">Инициализация...</div>
    </div>
    <div class="heading-info" id="headingInfo">Курс: —° | Азимут: —°</div>
</div>