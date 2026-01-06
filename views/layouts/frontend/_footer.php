<?php declare(strict_types=1);

use app\custom\widgets\frontend\scripts\ExternalScripts;
use app\modules\contacts\widgets\frontend\contacts\Contacts;
use app\modules\contacts\widgets\frontend\social\SocialMedia;
use app\modules\feedback\widgets\frontend\feedback\Feedback;
use app\modules\page\widgets\frontend\menu\Menu;
use yii\helpers\Url;

?>

<footer>
    <div class="container">
        <div class="footer-content">
            <div class="footer-column">
                <h3>IQuiz</h3>
                <p>Лучшие барные викторины в вашем городе. Присоединяйтесь к нашему интеллектуальному сообществу!</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-vk"></i></a>
                </div>
            </div>
            
            <div class="footer-column">
                <h3>Навигация</h3>
                <ul>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Главная</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Расписание квизов</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Все квизы</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Рейтинги команд</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Правила участия</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h3>Организаторам</h3>
                <ul>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Добавить квиз</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Партнерская программа</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Реклама на сайте</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Контакты для сотрудничества</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h3>Контакты</h3>
                <ul>
                    <li><i class="fas fa-envelope"></i> info@i-quiz.ru</li>
                    <li><a href="#"><i class="fab fa-vk"></i> Написать нам</a></li>
                </ul>
            </div>
        </div>
        
        <div class="copyright">
            <p>© <?= date('Y', time()) ?> IQuiz</p>
        </div>
    </div>
</footer>