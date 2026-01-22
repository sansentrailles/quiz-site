<?php declare(strict_types=1);

use app\custom\widgets\frontend\scripts\ExternalScripts;
use yii\helpers\Url;

$setting = Yii::$app->setting;

?>

<footer>
    <div class="container">
        <div class="footer-content">
            <div class="footer-column">
                <h3>IQuiz</h3>
                <p>Лучшие барные викторины в вашем городе. Присоединяйтесь к нашему интеллектуальному сообществу!</p>
                <div class="social-links">
                    <a href="<?= $setting->get('link.vk-group') ?>" target="_blank"><i class="fab fa-vk"></i></a>
                </div>
            </div>
            
            <div class="footer-column">
                <h3>Навигация</h3>
                <ul>
                    <li><a href="<?= Url::to("/") ?>"><i class="fas fa-chevron-right"></i> Главная</a></li>
                    <li><a href="<?=  Url::to("/quizes")  ?>"><i class="fas fa-chevron-right"></i> Все квизы</a></li>
                    <li><a href="<?= Url::to("/rating") ?>"><i class="fas fa-chevron-right"></i> Рейтинги команд</a></li>
                    <li><a href="<?= Url::to("/rules") ?>"><i class="fas fa-chevron-right"></i> Правила участия</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h3>Сотрудничество</h3>
                <ul>
                    <li><a href="<?= Url::to("/maintance") ?>"><i class="fas fa-chevron-right"></i> Партнеры</a></li>
                    <li><a href="<?= Url::to("/maintance") ?>"><i class="fas fa-chevron-right"></i> Сотрудничество</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h3>Контакты</h3>
                <ul>
                    <li><i class="fas fa-envelope"></i> info@i-quiz.ru</li>
                    <?php /*
                    <li><a href="#"><i class="fab fa-vk"></i> Написать нам</a></li>
                    */ ?>
                </ul>
            </div>
        </div>
        
        <div class="copyright">
            <p>© <?= date('Y', time()) ?> IQuiz</p>
        </div>
    </div>
</footer>

<div class="toast" id="successToast">
    <div class="toast-icon">
        <i class="fas fa-check-circle"></i>
    </div>
    <div class="toast-content">
        <h4></h4>
        <p>Мы свяжемся с вами в ближайшее время для подтверждения.</p>
    </div>
</div>