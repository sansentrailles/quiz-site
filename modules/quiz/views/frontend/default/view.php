<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\custom\helpers\DateHelper;
use app\modules\quiz\widgets\frontend\booking\Booking;

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

<?php $this->beginBlock('breadcrumbsBlock'); ?>
    <div class="breadcrumbs">
        <div class="container">
            <ul>
                <li><a href="<?=  Url::to('/') ?>"><i class="fas fa-home"></i> Главная</a></li>
                <li class="separator">/</li>
                <li><a href="<?=  Url::to('/quizes') ?>"></i> Квизы</a></li>
                <li class="separator">/</li>
                <li class="current">Квиз: <?= $quiz->title ?></li>
            </ul>
        </div>
    </div>
<?php $this->endBlock(); ?>

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
                
                <?php if ($quiz->items && !$quiz->isExpired) { ?>
                    <div class="quiz-features">
                        <h3><i class="fas fa-star"></i> Что вас ждет на квизе:</h3>
                        <div class="features-list">
                            <?php foreach ($quiz->itemsList as $item) { ?>
                                <p><i class="fas fa-check-circle"></i> <?= $item ?></p>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    
    <div class="quiz-sidebar">
        <?php if (!$quiz->isExpired) { ?>
            <?= $this->render('parts/_actual_sidebar', [
                'quiz' => $quiz,
            ]) ?>
            
        <?php } else { ?>
            <?= $this->render('parts/_expired_sidebar', [
                'stats' => $stats,
            ]) ?>
        <?php } ?>
        
        <?php if ($quiz->location) { ?>
            <?= $this->render('parts/_location', [
                'location' => $quiz->location,
            ]) ?>
        <?php } ?>
    </div>

    <?= Booking::widget([
        'action' => Url::to('/quizes/booking'),
        'quizId' => $quiz->id,
    ]) ?>
</div>

<?php if ($quiz->isExpired && count($quiz->participants) > 0) { ?>
    <?=  $this->render('parts/_quiz_result', [
        'participants' => $quiz->participants,
    ]) ?>
<?php } ?>

<?php if ($quiz->location && $quiz->location->latitude && $quiz->location->longitude) { ?>
    <?= $this->render('parts/_map', [
        'location' => $quiz->location,
    ]) ?>
<?php } ?>
