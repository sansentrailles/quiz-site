<?php

use app\modules\seo\widgets\frontend\seo\SeoWidget;

SeoWidget::widget([
    'refId' => 0,
    'section' => $seoSection,
    'view' => $this,
    'default' => $defaultSeo
]);

?>

<?php $this->beginBlock('heroBlock'); ?>
    <?= $this->render('@app/modules/main/views/frontend/main/parts/_top_v2') ?>
<?php $this->endBlock(); ?>


<section class="quiz-section" id="upcoming-quizzes">
    <div class="section-header">
        <h2>
            <i class="fas fa-calendar-alt section-icon"></i>
            Предстоящие квизы
        </h2>
    </div>
    
    <?php if (count($actualQuizes) > 0 ) { ?>
        <div class="quiz-list" id="upcoming-quiz-list">
            <?php foreach ($actualQuizes as $quiz) { ?>
                <?=  $this->render('parts/_quiz_item', [
                    'quiz' => $quiz,
                ])  ?>
            <?php } ?>
        </div>
    <?php } else { ?>
        <?= $this->render('parts/_no_actual') ?>
    <?php } ?>
</section>

<?php if (count($expiredQuizes) > 0) { ?>
    <section class="quiz-section" id="completed-quizzes">
        <div class="section-header">
            <h2>
                <i class="fas fa-history section-icon"></i>
                Завершенные квизы
            </h2>
        </div>
        
        <div class="quiz-list" id="completed-quiz-list">
            <?php foreach ($expiredQuizes as $quiz) { ?>
                <?=  $this->render('parts/_quiz_expired_item', [
                    'quiz' => $quiz,
                ])  ?>
            <?php } ?>
        </div>
    </section>
<?php } ?>
