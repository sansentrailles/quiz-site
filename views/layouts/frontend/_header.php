<?php

declare(strict_types=1);

use yii\helpers\Url;

?>

<header>
    <div class="container header-content">
        <div class="logo">
            <a href="<?= Url::to("/") ?>">
                <img src="/images/logo-w.png" alt="IQuiz лого">
            </a>
            <?php /*
            <i class="fas fa-brain"></i>
            */ ?>
            <div class="logo-text">
                <h1 class="google-sans-bold">IQuiz</h1>
                <p>Интеллектуальные игры в барах города</p>
            </div>
        </div>
        <nav>
            <ul>
                <li><a href="<?=  Url::to('/') ?>" class="active"><i class="fas fa-home"></i> Главная</a></li>
                <li><a href="<?=  Url::to('/maintance') ?>"><i class="fas fa-bars"></i> Квизы</a></li>
                <li><a href="<?=  Url::to('/maintance') ?>"><i class="fas fa-star"></i> Контакты</a></li>
            </ul>
        </nav>
    </div>
</header>
