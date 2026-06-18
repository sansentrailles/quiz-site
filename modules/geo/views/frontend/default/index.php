<div class="header">
    <h1>📍 GPS Трекер</h1>
    <p>Отслеживание местоположения в реальном времени</p>
</div>

<div class="coords-panel">
    <div class="status">
        <div class="status-indicator" id="statusIndicator"></div>
        <div class="status-text" id="statusText">Инициализация...</div>
    </div>

    <div class="coords-grid">
        <div class="coord-item">
            <div class="coord-label">Широта</div>
            <div class="coord-value" id="latitude">--</div>
        </div>
        <div class="coord-item">
            <div class="coord-label">Долгота</div>
            <div class="coord-value" id="longitude">--</div>
        </div>
        <div class="coord-item">
            <div class="coord-label">Точность</div>
            <div class="coord-value" id="accuracy">--</div>
        </div>
        <div class="coord-item">
            <div class="coord-label">Скорость</div>
            <div class="coord-value" id="speed">--</div>
        </div>
    </div>
</div>

<div id="map"></div>

<div class="info-text">
    Для работы требуется разрешение на доступ к геолокации
</div>