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
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['width' => '5%'],
            ],

            [
                'headerOptions' => ['width' => '10%'],
                'attribute' => 'team_name',
            ],

            [
                'headerOptions' => ['width' => '10%'],
                'attribute' => 'name',
            ],

            [
                'attribute' => 'persons',
                'headerOptions' => ['width' => '5%'],
            ],

            [
                'headerOptions' => ['width' => '5%'],
                'class' => ActionColumn::class,
                'contentOptions' => ['style' => 'text-align: center;'],
            ],
        ],
    ]); ?>
    <?php //= Html::submitButton(Module::t('common', 'BUTTON_SAVE'), ['class' => 'btn btn-sm btn-primary']) ?>
<?php echo Html::endForm(); ?>
