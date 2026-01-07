<?php

use yii\helpers\Html;
use app\custom\helpers\DateHelper;

// 15 октября, вт в 20:00
$timestamp = $quiz->date;
$day = date('d', $timestamp);
$month = DateHelper::getMonth2(date('n', $timestamp));
$weekday = DateHelper::getWeekdayString(date('N', $timestamp), false);
$date = $day.' '.$month.', '.$weekday.', '.$quiz->time;

// var_dump($quiz->location);

?>
<div class="quiz-card">
    <?php /*
    <div class="quiz-badge">Популярный</div>
    */?>
    <img src="<?= $quiz->imagePath ?>" alt="<?=  Html::encode($quiz->title) ?>" class="quiz-image">
    <div class="quiz-card-content">
        <div class="quiz-header">
            <h3 class="quiz-title"><?= $quiz->title ?></h3>

            <?php foreach ($quiz->labels as $label) { ?>
                <span class="quiz-category"><?=  $label->title ?></span>
            <?php } ?>
        </div>
        
        <div class="quiz-details">
            <div class="detail-item">
                <i class="far fa-calendar-alt"></i>
                <span class="color-accent"><?= $date ?></span>
            </div>

            <?php if ($quiz->location) { ?>
                <div class="detail-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span class="color-info"><?= $quiz->location->title ?></span>
                </div>
            <?php } ?>

            <p style="margin-top: 10px; color: #667;"><?= $quiz->desc ?></p>
        </div>
        
        <?php /*
        <div class="participants">
            <div style="flex-grow: 1;">
                <div class="participants-count">42/60 участников</div>
                <div class="progress-bar">
                    <div class="progress" style="width: 70%"></div>
                </div>
            </div>
            <div style="font-weight: 600; color: var(--success);">
                18 мест
            </div>
        </div>
        */ ?>
        
        <div class="quiz-footer">
            <div class="quiz-price"><?= $quiz->price ?> руб.</div>
            <div class="quiz-actions">
                <a href="/" class="link-signup" onclick="openSignupModal(1)">Записаться</a>
                <a href="<?= $quiz->link ?>" class="link-details">Подробнее</a>
                <?php /*
                <a href="/" class="link-details"><i class="fas fa-chevron-right"></i></a>
                */ ?>
            </div>
        </div>
    </div>
</div>
