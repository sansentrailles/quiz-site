<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\quiz\Module;
use app\custom\widgets\backend\grid\InputColumn;
use app\custom\widgets\backend\grid\ActionColumn;

// @var $this yii\web\View
// @var $searchModel app\modules\quiz\models\QuizBookingSearch
// @var $dataProvider yii\data\ActiveDataProvider

?>

<p>
    <br><br>
</p>

<?= Html::beginForm(['participants/save-points'], 'post', ['enctype' => 'multipart/form-data']) ?>
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'format' => 'raw',
                'value' => function ($model) {
                    $url = ['/admin/quiz/participants/apply-booking', 'id' => $model->id];
                    $label = "<i class='fa fa-arrow-left'></i>";
                    return Html::a($label, $url, ['title' => 'Принять заявку']);
                },
                'headerOptions' => ['width' => '1%', 'style' => 'text-align: center;'],
            ],

            [
                'headerOptions' => ['width' => '10%'],
                'format' => 'raw',
                'attribute' => 'team_name',
                'value' => function ($model) {
                    if ($model->is_single) {
                        return '<span class="text-red">Без команды</span>';
                    }

                    return $model->team_name;
                }
            ],

            [
                'headerOptions' => ['width' => '8%'],
                'attribute' => 'name',
            ],

            [
                'attribute' => 'persons',
                'headerOptions' => ['width' => '3%'],
            ],

            [
                'headerOptions' => ['width' => '3%'],
                'value' => function ($model) {
                    return date('d.m H:i', $model->created_at);
                },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '1%', 'style' => 'text-align: center;'], // Центрирует заголовок
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'], // Центрирует кнопки
                'template' => '{delete}',
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'delete') {
                        // Возвращаем кастомный URL (например, другой контроллер или параметры)
                        return ['participants/delete-booking', 'id' => $model->id];
                    }
                    // Для остальных кнопок используем стандартную логику
                    return \yii\helpers\Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>
    <?php //= Html::submitButton(Module::t('common', 'BUTTON_SAVE'), ['class' => 'btn btn-sm btn-primary']) ?>
<?php echo Html::endForm(); ?>
