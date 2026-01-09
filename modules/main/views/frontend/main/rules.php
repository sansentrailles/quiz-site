<?php

use yii\helpers\Url;
use app\modules\seo\widgets\frontend\seo\SeoWidget;

$setting = Yii::$app->setting;
$vkLink = $setting->get('link.vk-group');

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
                <li class="current">Правила участия в квизах</li>
            </ul>
        </div>
    </div>
<?php $this->endBlock(); ?>

<div class="page-title">
    <i class="fas fa-book"></i>
    <h1>Правила участия в квизах</h1>
</div>

<p class="page-subtitle">
    Чтобы каждый участник мог насладиться игрой в полной мере, мы разработали простые и понятные правила.
    Пожалуйста, ознакомьтесь с ними перед посещением квиза.
</p>

<div class="rules-container">
    <div class="rule-card">
        <div class="rule-card-header">
            <div class="rule-card-icon">
                <i class="fas fa-users"></i>
            </div>
            <h2 class="rule-card-title">Формирование команд</h2>
        </div>
        <div class="rule-card-content">
            <p>Команды формируются самостоятельно или на месте. Максимальное количество участников в команде — 6 человек.</p>
            <ul>
                <li>Минимальный размер команды — 2 человека</li>
                <li>Можно приходить одному — мы поможем найти команду</li>
                <li>Название команды не должно содержать нецензурные выражения</li>
                <li>Дети до 16 лет допускаются только в сопровождении взрослых</li>
            </ul>
        </div>
    </div>
    
    <div class="rule-card warning">
        <div class="rule-card-header">
            <div class="rule-card-icon">
                <i class="fas fa-mobile-alt"></i>
            </div>
            <h2 class="rule-card-title">Использование телефонов</h2>
        </div>
        <div class="rule-card-content">
            <p>Во время игры использование телефонов и других устройств для поиска ответов строго запрещено.</p>
            <ul>
                <li>Телефоны должны быть переведены в беззвучный режим</li>
                <li>При обнаружении факта использования интернета команда дисквалифицируется</li>
                <li>Разрешается использовать телефон только для фотографирования</li>
                <li>В аудио-раундах можно использовать наушники</li>
            </ul>
        </div>
    </div>
    
    <div class="rule-card success">
        <div class="rule-card-header">
            <div class="rule-card-icon">
                <i class="fas fa-ticket-alt"></i>
            </div>
            <h2 class="rule-card-title">Регистрация и оплата</h2>
        </div>
        <div class="rule-card-content">
            <p>Регистрация на квиз обязательна. Вы можете записаться онлайн или по телефону.</p>
            <ul>
                <li>Оплата производится на месте перед началом игры</li>
                <li>При отмене за 24 часа до начала — полный возврат средств</li>
                <li>При отмене менее чем за 24 часа — возврат 50% стоимости</li>
                <li>При неявке без предупреждения оплата не возвращается</li>
            </ul>
        </div>
    </div>
    
    <div class="rule-card info">
        <div class="rule-card-header">
            <div class="rule-card-icon">
                <i class="fas fa-glass-cheers"></i>
            </div>
            <h2 class="rule-card-title">Поведение в баре</h2>
        </div>
        <div class="rule-card-content">
            <p>Мы играем в барах и пабах, поэтому соблюдайте правила заведения и уважайте других гостей.</p>
            <ul>
                <li>Минимальный заказ — один напиток на человека</li>
                <li>Не мешайте другим командам во время обсуждения ответов</li>
                <li>Соблюдайте тишину во время озвучивания вопросов</li>
                <li>Будьте вежливы с ведущим и другими участников</li>
            </ul>
        </div>
    </div>
    
    <div class="rule-card">
        <div class="rule-card-header">
            <div class="rule-card-icon">
                <i class="fas fa-award"></i>
            </div>
            <h2 class="rule-card-title">Определение победителей</h2>
        </div>
        <div class="rule-card-content">
            <p>Победитель определяется по наибольшему количеству баллов, набранных за все раунды.</p>
            <ul>
                <li>В спорных ситуациях решение ведущего является окончательным</li>
                <li>Апелляции принимаются только до окончания игры</li>
                <li>При равенства баллов проводится дополнительный вопрос</li>
                <li>Результаты публикуются на нашем сайте на следующий день</li>
            </ul>
        </div>
    </div>
    
    <div class="rule-card warning">
        <div class="rule-card-header">
            <div class="rule-card-icon">
                <i class="fas fa-ban"></i>
            </div>
            <h2 class="rule-card-title">Запрещенные действия</h2>
        </div>
        <div class="rule-card-content">
            <p>Некоторые действия могут привести к дисквалификации команды без возврата оплаты.</p>
            <ul>
                <li>Использование интернета для поиска ответов</li>
                <li>Подсказки другим командам или получение подсказок извне</li>
                <li>Грубое поведение по отношению к другим участникам или персоналу</li>
                <li>Нарушение правил заведения, в котором проходит квиз</li>
            </ul>
        </div>
    </div>
</div>

<?= $this->render('parts/_faq', [
    'faqItems' => $faqItems,
]) ?>

<section class="contacts-section">
    <div class="contacts-title">
        <i class="fas fa-headset"></i>
        <h2>Остались вопросы?</h2>
    </div>
    <p class="contacts-description">
        Если у вас есть дополнительные вопросы о правилах участия или вы хотите уточнить какие-то моменты, 
        свяжитесь с нами любым удобным способом. Мы всегда рады помочь!
    </p>
    
    <div class="contact-methods">
        <?php /*
        <div class="contact-method">
            <i class="fas fa-phone-alt"></i>
            <div>
                <h3>Телефон</h3>
                <p>+7 (999) 123-45-67</p>
            </div>
        </div>
        */ ?>
        
        <div class="contact-method">
            <i class="fas fa-envelope"></i>
            <div>
                <h3>Email</h3>
                <p>info@i-quiz.ru</p>
            </div>
        </div>
        
        <div class="contact-method">
            <i class="fab fa-vk"></i>
            <div>
                <h3>ВКонтакте</h3>
                <p>
                    <a href="<?= $vkLink ?>" target="_blank"><?= $vkLink ?></a>
                </p>
            </div>
        </div>
    </div>
</section>