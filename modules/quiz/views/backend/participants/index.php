<?php declare(strict_types=1);

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\quiz\Module;
use app\modules\quiz\models\Participant;
use app\custom\widgets\backend\grid\InputColumn;
use app\custom\widgets\backend\grid\ActionColumn;

// @var $this yii\web\View
// @var $searchModel app\modules\quiz\models\ParticipantSearch
// @var $dataProvider yii\data\ActiveDataProvider

$this->title = Module::t('common', 'QUIZ_PARTICIPANTS_TITLE').": ".$quiz->title ."(".date('d.m.Y', $quiz->date).")";
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

    <?= Html::beginForm(['participants/save-points'], 'post', ['enctype' => 'multipart/form-data']) ?>
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
                    'headerOptions' => ['width' => '5%'],
                    'class' => ActionColumn::class,
                    'contentOptions' => ['style' => 'text-align: center;'],
                ],
            ],
        ]); ?>
        <?= Html::submitButton(Module::t('common', 'BUTTON_SAVE'), ['class' => 'btn btn-sm btn-primary']) ?>
    <?php echo Html::endForm(); ?>
    
    <br>
    <div class="form-group mt-5">
        <?php if (count($dataProvider->getModels()) > 0) { ?>
            <?= Html::beginForm(['participants/set-places'], 'post', ['enctype' => 'multipart/form-data']) ?>
                <?= Html::hiddenInput('quizId', $quiz->id) ?>
                <div class="text-green">Если для команд заполненны заработанные баллы за квиз, нажмите кнопку "<?= Module::t('common', 'BUTTON_SET_PLACES') ?>" для распределения мест</div>
                <div class="text-green">Для корректировки мест, заполните корректные значения в поле "Место" в таблице</div>
                <div class="text-red">Рекомендуется запускать когда очки всех команд прописаны</div><br>
                <?= Html::submitButton(Module::t('common', 'BUTTON_SET_PLACES'), ['class' => 'btn btn-sm btn-warning']) ?>
            <?php echo Html::endForm(); ?>
        <?php } ?>
    </div>
</div>
