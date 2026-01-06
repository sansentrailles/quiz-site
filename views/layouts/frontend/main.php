<?php declare(strict_types=1);

// @var $this \yii\web\View
// @var $content string

use yii\helpers\Html;
use app\assets\AppAsset;

AppAsset::register($this);

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
    <?php $this->head() ?>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=default,fetch" defer></script>
</head>

<body>
    <?php $this->beginBody(); ?>
        <?php echo $this->render('_header'); ?>
            <main class="container">
                <?php echo $content; ?>
            </main>
        <?php echo $this->render('_footer'); ?>
    <?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
