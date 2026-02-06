<?php

use yii\helpers\Url;

use app\modules\seo\widgets\frontend\seo\SeoWidget;

SeoWidget::widget([
    'refId' => 0,
    'section' => $seoSection,
    'view' => $this,
    'default' => $defaultSeo
]);

$places = [
    1 => 'fa-trophy gold-medal',
    2 => 'fa-trophy silver-medal',
    3 => 'fa-trophy bronze-medal',
];

$trends = [
    'up' => ['icon' => 'fa-arrow-up', 'cell' => 'trend-up'],
    'down' => ['icon' => 'fa-arrow-down', 'cell' => 'trend-down'],
    'same' => ['icon' => 'fa-minus', 'cell' => 'trend-stable'],
];

$models = $provider->getModels();

?>

<?php $this->beginBlock('breadcrumbsBlock'); ?>
    <div class="breadcrumbs">
        <div class="container">
            <ul>
                <li><a href="<?=  Url::to('/') ?>"><i class="fas fa-home"></i> Главная</a></li>
                <li class="separator">/</li>
                <li class="current">Рейтинг команд</li>
            </ul>
        </div>
    </div>
<?php $this->endBlock(); ?>

<div class="rating-page">
    <h1 class="rating-page-title">
        <i class="fas fa-trophy"></i> Рейтинг команд IQuiz
    </h1>
    <p class="page-description">
        Текущий рейтинг команд. Рейтинг обновляется после каждого проведенного квиза.
    </p>

    <?= $this->render('parts/_rating_stats', ['stats' => $stats]) ?>

    <div class="rating-section">
        <div class="rating-section-header">
            <h2 class="rating-section-title">
                <i class="fas fa-list-ol"></i> Таблица рейтинга
            </h2>
            <?php /*
                <div class="controls">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="teamSearch" placeholder="Поиск команды...">
                    </div>
                </div>
            */ ?>
        </div>

        <table class="rating-table">
            <thead>
                <tr>
                    <th class="place-number-header">Место</th>
                    <th class="team-name">Команда</th>
                    <th class="games-cell-header">Кол-во игр <i class="fas fa-gamepad"></i></th>
                    <th class="points-cell-header">Всего баллов <i class="fas fa-star"></i></th>
                    <th class="avg-points-header">Средний балл <i class="fas fa-chart-line"></i></th>
                    <th class="trend-cell-header">Тренд <i class="fas fa-arrow-trend-up"></i></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($models as $ratingItem) { ?>
                    <tr>
                        <td class="<?php if($ratingItem <= 3) { ?>medal-cell<?php } else {?>place-number<?php } ?>">
                            <?php if(isset($places[$ratingItem['place']])) { ?>
                                <i class="fas fa-trophy <?= $places[$ratingItem['place']] ?>"></i>
                            <?php } else { ?>
                                <?= $ratingItem['place'] ?>
                            <?php } ?>
                        </td>
                        <td><div class="team-name"><?= $ratingItem['title'] ?></div></td>
                        <td class="games-cell"><?= $ratingItem['games_played'] ?></td>
                        <td class="points-cell"><?= $ratingItem['total_points'] ?></td>
                        <td class="avg-points"><?= number_format($ratingItem['avg_points'], 1, '.', 0) ?></td>
                        <?php if (isset($trends[$ratingItem['trend']])) { ?>
                            <td class="trend-cell <?= $trends[$ratingItem['trend']]['cell'] ?>"><i class="fas <?= $trends[$ratingItem['trend']]['icon'] ?>"></i></td>
                        <?php } else { ?>
                            <td class="trend-cell">
                                <?= $ratingItem['trend'] ?>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <?= $this->render('parts/_rating_paginator', [
            'provider' => $provider,
        ]) ?>
    </div>
    
    <?= $this->render('parts/_encouragement') ?>
</div>