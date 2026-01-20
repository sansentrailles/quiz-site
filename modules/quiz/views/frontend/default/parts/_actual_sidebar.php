<?php

$setting = Yii::$app->setting;

?>

<div class="price-card">
    <div class="price-container">
        <div class="price-label">Стоимость участия</div>
        <div class="price"><?= $quiz->price ?> руб.</div>
        <div class="price-label">за участника</div>
    </div>
    
    <?php /*
    <div class="participants-info">
        <div class="participants-count">42/60 участников уже записались</div>
        <div class="progress-bar">
            <div class="progress" style="width: 70%"></div>
        </div>
        <div class="places-left">Осталось 18 мест</div>
    </div>
    */ ?>
    
    <a href="<?= $setting->get('link.booking') ?>" class="btn-signup" target="_blank">
        <i class="fas fa-ticket-alt"></i> Записаться на квиз
    </a>
    
    <?php /*
    <p style="margin-top: 15px; color: var(--gray); font-size: 0.9rem;">Запись открыта до 14 октября</p>
    */ ?>
</div>
