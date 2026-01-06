<?php

use yii\helpers\Html;
?>
<div class="quiz-card">
    <?php /*
    <div class="quiz-badge">Популярный</div>
    */?>
    <img src="<?= $quiz->imagePath ?>" alt="<?=  Html::encode($quiz->title) ?>" class="quiz-image">
    <div class="quiz-content">
        <div class="quiz-header">
            <h3 class="quiz-title"><?= $quiz->title ?></h3>
            <span class="quiz-category">Кино и сериалы</span>
            <span class="quiz-category">Музыка</span>
            <span class="quiz-category">Общие знания</span>
        </div>
        
        <div class="quiz-details">
            <div class="detail-item">
                <i class="far fa-calendar-alt"></i>
                <span>15 октября, вт в 20:00</span>
            </div>
            <div class="detail-item">
                <i class="fas fa-map-marker-alt"></i>
                <span><?= $quiz->location ?></span>
            </div>
            <p style="margin-top: 10px; color: #666;">Викторина по фильмам и сериалам 90-х годов. Вас ждут вопросы о культовых фильмах и актерах эпохи.</p>
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
                <a href="/" class="btn-details" onclick="showQuizDetails(1)"><i class="fas fa-chevron-right"></i></a>
                <a href="/" class="btn-signup" onclick="openSignupModal(1)">Записаться</a>
            </div>
        </div>
    </div>
</div>