<?php

declare(strict_types=1);

use yii\helpers\Html;
use app\custom\helpers\AppHelper;
use app\modules\seo\widgets\frontend\metric\MetricCode;

// @var $this \yii\web\View
// @var $content string



// use app\assets\AppAsset;
// AppAsset::register($this);

?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php /*
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
    */ ?>
    <title><?php echo Html::encode($this->title); ?></title>
    <?= Html::csrfMetaTags() ?>

    <link rel="stylesheet" href="/css/<?= AppHelper::getManifestData('rev-manifest.json', 'main.css') ?>">
    <link rel="apple-touch-icon" sizes="57x57" href="/images/favicon/media/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/images/favicon/media/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/images/favicon/media/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/images/favicon/media/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/images/favicon/media/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/images/favicon/media/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/images/favicon/media/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/images/favicon/media/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/media/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/images/favicon/media/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/media/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/images/favicon/media/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/media/favicon-16x16.png">
    <link rel="shortcut icon" href="/images/favicon/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/images/favicon/favicon.ico" type="image/x-icon">

    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/images/favicon/media/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <script src="/js/<?= AppHelper::getManifestData('rev-manifest.json', 'main.js') ?>" defer></script>

    <?php $this->head() ?>

    <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=default,fetch" defer></script>

    <?= MetricCode::widget([
        'place' => MetricCode::PLACE_HEAD,
    ]) ?>
</head>

<body>
    <?php $this->beginBody(); ?>
        <?php echo $this->render('_header'); ?>

            <?php if (isset($this->blocks['heroBlock'])): ?>
                <?= $this->blocks['heroBlock'] ?>
            <?php endif; ?>

            <?php if (isset($this->blocks['breadcrumbsBlock'])): ?>
                <?= $this->blocks['breadcrumbsBlock'] ?>
            <?php endif; ?>

            <main class="container">
                <?php echo $content; ?>
            </main>
        <?php echo $this->render('_footer'); ?>

        <?= MetricCode::widget([
            'place' => MetricCode::PLACE_BODY,
        ]) ?>
    <?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
