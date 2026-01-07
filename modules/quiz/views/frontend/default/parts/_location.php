<div class="location-card">
    <h3><i class="fas fa-map-marker-alt"></i> Локация</h3>
    
    <div class="location-details">
        <div class="location-item">
            <i class="fas fa-beer"></i>
            <div class="location-text">
                <h4><?= $location->title ?></h4>
                <p><?= $location->desc ?></p>
            </div>
        </div>
        
        <div class="location-item">
            <i class="fas fa-location-arrow"></i>
            <div class="location-text">
                <h4>Адрес</h4>
                <p><?= $location->address ?></p>
            </div>
        </div>
        
        <?php /*
        <div class="location-item">
            <i class="fas fa-subway"></i>
            <div class="location-text">
                <h4>Метро</h4>
                <p>Станция "Киевская", 5 минут пешком</p>
            </div>
        </div>
        */ ?>
        
        <div class="location-item">
            <i class="fas fa-clock"></i>
            <div class="location-text">
                <h4>Время работы</h4>
                <p><?= str_replace("\n", '<br>', $location->workmode) ?></p>
            </div>
        </div>
    </div>

    <?php /*
    <a href="#" class="btn-map action-button" id="show-map">
        <i class="fas fa-map"></i> Открыть карту
    </a>
    */ ?>
    
    <button class="btn-map" id="show-map">
        <i class="fas fa-map"></i> Посмотреть на карте
    </button>
</div>
