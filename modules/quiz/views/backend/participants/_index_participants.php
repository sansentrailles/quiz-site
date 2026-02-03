<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\quiz\Module;
use app\custom\widgets\backend\grid\InputColumn;
use app\custom\widgets\backend\grid\ActionColumn;

// @var $this yii\web\View
// @var $searchModel app\modules\quiz\models\ParticipantSearch
// @var $dataProvider yii\data\ActiveDataProvider

?>

<p>
    <?php echo Html::a(Module::t('common', 'QUIZ_PARTICIPANT_CREATE'), ['create', 'quizId' => $quiz->id], ['class' => 'btn btn-success']); ?>
</p>

<?= Html::beginForm(['participants/save-points'], 'post', ['enctype' => 'multipart/form-data']) ?>
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // [
            //     'class' => 'yii\grid\SerialColumn',
            //     'headerOptions' => ['width' => '2%'],
            // ],

            [
                'headerOptions' => ['width' => '80%'],
                'attribute' => 'team_id',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->team->title, ['/admin/quiz/participants/update', 'id' => $model->id]);
                },
            ],

            [
                'attribute' => 'points',
                // 'headerOptions' => ['width' => '5%'],
                'contentOptions' => ['style' => 'text-align: center'],
                'class' => InputColumn::class,
                'name' => 'points_list',
            ],

            [
                'attribute' => 'place',
                'headerOptions' => ['width' => '5%'],
                'contentOptions' => ['style' => 'text-align: center'],
                'class' => InputColumn::class,
                'name' => 'places',
            ],

            [
                'headerOptions' => ['width' => '3%'],
                'template' => '{delete}',
                'class' => ActionColumn::class,
                'contentOptions' => ['style' => 'text-align: center;'],
            ],
        ],
    ]); ?>
    <?= Html::submitButton(Module::t('common', 'BUTTON_SAVE'), ['class' => 'btn btn-sm btn-primary']) ?>
<?php echo Html::endForm(); ?>
