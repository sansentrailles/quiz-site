<?php

use yii\helpers\Url;
use app\modules\seo\widgets\frontend\seo\SeoWidget;

SeoWidget::widget([
    'refId' => 0,
    'section' => $seoSection,
    'view' => $this,
    'default' => $defaultSeo
]);

?>

<?php $this->beginBlock('breadcrumbsBlock'); ?>
    <div class="breadcrumbs">
        <div class="container">
            <ul>
                <li><a href="<?=  Url::to('/') ?>"><i class="fas fa-home"></i> Главная</a></li>
                <li class="separator">/</li>
                <li class="current">Страница не найдена (404)</li>
            </ul>
        </div>
    </div>
<?php $this->endBlock(); ?>


<div class="error-container">
    <div class="error-number">404</div>
    
    <div class="error-icon">
        <i class="fas fa-question-circle"></i>
    </div>
    
    <h1 class="error-title">Упс! Страница не найдена</h1>
    
    <p class="error-subtitle">
        К сожалению, запрашиваемая вами страница не существует или была перемещена
    </p>
    
    <div class="error-message">
        <h3><i class="fas fa-exclamation-triangle"></i> Что случилось?</h3>
        <p>Возможно, вы перешли по устаревшей ссылке, ввели неправильный адрес или страница была удалена.</p>
        <p>Но не расстраивайтесь! У нас есть множество интересных квизов, которые вас точно заинтересуют.</p>
    </div>
    
    <!-- Действия -->
    <div class="error-actions">
        <a href="<?= Url::to('/') ?>" class="btn btn-primary">
            <i class="fas fa-home"></i> Вернуться на главную
        </a>
    </div>
</div>
