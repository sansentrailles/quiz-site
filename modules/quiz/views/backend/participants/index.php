<?php declare(strict_types=1);

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\quiz\Module;
use app\modules\quiz\models\Participant;
use app\custom\widgets\backend\grid\LinkColumn;
use app\custom\widgets\backend\grid\ActionColumn;

// @var $this yii\web\View
// @var $searchModel app\modules\quiz\models\ParticipantSearch
// @var $dataProvider yii\data\ActiveDataProvider

$this->title = Module::t('common', 'QUIZ_PARTICIPANTS');
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'QUIZES'), 'url' => ['/admin/quiz/quizes']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['boxheader'] = [
    'icon' => 'fa-cubes',
    'text' => $this->title,
];

$seoSection = 'quiz';

?>
<div class="index">
    <p>
        <?php echo Html::a(Module::t('common', 'QUIZ_PARTICIPANT_CREATE'), ['create', 'quizId' => $quiz->id], ['class' => 'btn btn-success']); ?>
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
                'attribute' => 'team_id',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->team->title, ['/admin/quiz/participants/update', 'id' => $model->id]);
                },
            ],

            [
                'attribute' => 'points',
                'headerOptions' => ['width' => '5%'],
            ],

            [
                'attribute' => 'place',
                'headerOptions' => ['width' => '5%'],
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
