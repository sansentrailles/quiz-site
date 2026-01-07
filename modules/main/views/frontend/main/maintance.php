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
                <li class="current">Страница в разработке</li>
            </ul>
        </div>
    </div>
<?php $this->endBlock(); ?>


<div class="development-container">
    <div class="development-icon">
        <i class="fas fa-tools"></i>
    </div>
    
    <h1 class="development-title">Страница в разработке</h1>
    
    <p class="development-subtitle">
        Мы активно работаем над созданием этой страницы. Скоро здесь появится новый увлекательный квиз!
    </p>
    
    <div class="back-to-home">
        <a href="<?= Url::to("/") ?>" class="btn-home">
            <i class="fas fa-arrow-left"></i> Вернуться на главную
        </a>
    </div>
</div>