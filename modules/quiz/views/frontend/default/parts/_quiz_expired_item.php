<?php

use yii\helpers\Html;
use app\custom\helpers\DateHelper;

// 15 октября, вт в 20:00
$timestamp = $quiz->date;
$day = date('d', $timestamp);
$month = DateHelper::getMonth2(date('n', $timestamp));
$weekday = DateHelper::getWeekdayString(date('N', $timestamp), false);
$date = $day.' '.$month.', '.$weekday.', '.$quiz->time;

$setting = Yii::$app->setting;

?>

<div class="quiz-card">
    <div class="quiz-badge completed">Завершен</div>
    <img src="<?=  $quiz->imagePath ?>?>" alt="<?= Html::encode($this->title) ?>" class="quiz-card-image">
    <div class="quiz-card-content">
        <div class="quiz-header">
            <h3 class="quiz-card-title"><?= $quiz->title ?></h3>
            <?php foreach ($quiz->labels as $label) { ?>
                <span class="quiz-category"><?= $label->title ?></span>
            <?php } ?>
        </div>
        
        <div class="quiz-details">
            <div class="detail-item">
                <i class="far fa-calendar-alt"></i>
                <span><?= $date ?></span>
            </div>

            <?php if ($quiz->location) { ?>
                <div class="detail-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span class="color-info"><?= $quiz->location->title ?></span>
                </div>
            <?php } ?>
            <p style="margin-top: 10px; color: #667;"><?= $quiz->desc ?></p>
        </div>
        
        <div class="quiz-footer">
            <div class="quiz-price completed"><?= $quiz->price ?> руб.</div>
            <div class="quiz-actions">
                <a href="<?= $quiz->link ?>" class="link-details">Итоги</a>
            </div>
        </div>
    </div>
</div>
