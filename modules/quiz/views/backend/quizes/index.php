<?php declare(strict_types=1);

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\quiz\Module;
use app\modules\quiz\models\Quiz;
use app\custom\widgets\backend\grid\LinkColumn;
use app\custom\widgets\backend\grid\ActionColumn;
use app\custom\widgets\backend\grid\ToggleColumn;

/**
 * @var yii\web\View $this
 * @var app\modules\quiz\forms\backend\search\QuizSearch $searchModel 
 * @var $dataProvider yii\data\ActiveDataProvider
 */

$this->title = Module::t('common', 'QUIZES');
$this->params['breadcrumbs'][] = $this->title;

$this->params['boxheader'] = [
    'icon' => 'fa-question',
    'text' => $this->title,
];

$seoSection = 'quiz';

?>
<div class="index">
    <p>
        <?php echo Html::a(Module::t('common', 'QUIZ_CREATE'), ['create'], ['class' => 'btn btn-success']); ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['width' => '5%'],
            ],

            [
                    'attribute' => 'date',
                    'headerOptions' => ['width' => '5%'],
                    'value' => static fn ($model) => date('d.m.Y', $model->date),
                ],

            [
                'attribute' => 'image',
                'headerOptions' => ['width' => '15%'],
                'format' => 'raw',
                'value' => static fn ($model) => Html::img($model->getImagePath(), ['class' => 'img-responsive']),
            ],

            [
                'attribute' => 'title',
                'class' => LinkColumn::class,
                'action' => 'update',
            ],

            [
                'headerOptions' => ['width' => '10%'],
                'label' => Module::t('common', 'QUIZ_PARTICIPANTS'),
                'format' => 'raw',
                'value' => function($model) {
                    $url = Url::to(['/admin/quiz/participants', 'quizId' => $model->id]);
                    return Html::a(Module::t('common', 'QUIZ_PARTICIPANTS'), $url);
                }
            ],

            [
                'class' => ToggleColumn::class,
                'contentOptions' => ['style' => 'text-align: center'],
                'attribute' => 'is_visible',
                'action' => 'toggle-visible',
                'filter' => [
                    Quiz::STATUS_INVISIBLE => Module::t('common', 'INACTIVE'),
                    Quiz::STATUS_VISIBLE => Module::t('common', 'ACTIVE'),
                ],
            ],

            [
                'headerOptions' => ['width' => '5%'],
                'class' => ActionColumn::class,
                'contentOptions' => ['style' => 'text-align: center;'],
            ],
        ],
    ]); ?>
    <?php echo Html::endForm(); ?>
</div>
