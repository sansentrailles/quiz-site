<?php

declare(strict_types=1);

use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 * @var string $content
 */

?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo Html::encode($this->title); ?></title>
    <?= Html::csrfMetaTags(); ?>

    <?=  $this->render('inner/_style') ?>

</head>
<body data-route='{
    "points": [
        {
            "latitude": "55.34345419",
            "longitude": "61.33763417",
            "title": "КП2",
            "message": "Вы достигли точки Стелла"
        },
        {
            "latitude": "55.34305231",
            "longitude": "61.33882042",
            "title": "КП1",
            "message": "Вы достигли точки Магазин"
        }
    ],
    "title": "Начальный",
    "arrival_radius": 30
}'>
    <?php $this->beginBody(); ?>
        <?php echo $content; ?>
        <?=  $this->render('inner/_script') ?>
    <?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
