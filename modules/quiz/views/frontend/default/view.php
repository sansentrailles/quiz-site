<?php

use yii\helpers\Html;
use app\custom\helpers\DateHelper;

use app\modules\seo\widgets\frontend\seo\SeoWidget;

SeoWidget::widget([
    'refId' => 0,
    'section' => $seoSection,
    'view' => $this,
    'default' => $defaultSeo
]);

$timestamp = $quiz->date;
$day = date('d', $timestamp);
$month = DateHelper::getMonth2(date('n', $timestamp));
$weekday = DateHelper::getWeekdayString(date('N', $timestamp));
$date = $day.' '.$month.', '.$weekday;

$setting = Yii::$app->setting;

?>

<div class="quiz-page">
    <div class="quiz-main">
        <div class="quiz-image-container">
            <img src="<?= $quiz->imagePath ?>" alt="<?= Html::encode($quiz->title) ?>" class="quiz-image">
        </div>
        
        <div class="quiz-content">
            <div class="quiz-header">
                <h1 class="quiz-title"><?= $quiz->title ?></h1>

                <?php foreach($quiz->labels as $label) { ?>
                    <span class="quiz-category"><?=  $label->title ?></span>
                <?php } ?>
            </div>
            
            <div class="quiz-details-grid">
                <div class="detail-card">
                    <h3><i class="far fa-calendar-alt"></i> Дата и время</h3>
                    <p><?= $date ?></p>
                    <p style="font-size: 1.1rem; color: var(--gray); margin-top: 5px;">Начало в <?= $quiz->time ?></p>
                </div>
                
                <?php if ($quiz->location) { ?>
                    <div class="detail-card">
                        <h3><i class="fas fa-map-marker-alt"></i> Локация</h3>
                        <p><?= $quiz->location->title ?></p>
                        <p style="font-size: 1.1rem; color: var(--gray); margin-top: 5px;"><?= $quiz->location->address ?></p>
                    </div>
                <?php } ?>
            </div>
            
            <div class="quiz-description">
                <h2><i class="fas fa-info-circle"></i> Описание квиза</h2>

                <?= $quiz->text ?>
                
                <?php if ($quiz->items) { ?>
                    <div class="quiz-features">
                        <h3><i class="fas fa-star"></i> Что вас ждет на квизе:</h3>
                        <ul class="features-list">
                            <?php foreach ($quiz->itemsList as $item) { ?>
                                <li><i class="fas fa-check-circle"></i> <?= $item ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    
    <!-- Боковая панель с записью -->
    <div class="quiz-sidebar">
        <div class="signup-card">
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
        
        <?php if ($quiz->location) { ?>
            <?= $this->render('parts/_location', [
                'location' => $quiz->location,
            ]) ?>
        <?php } ?>
    </div>
</div>

<?= $this->render('parts/_map', [
    'location' => $quiz->location,
]) ?>
