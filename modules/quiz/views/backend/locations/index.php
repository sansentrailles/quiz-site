<?php declare(strict_types=1);

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\quiz\Module;
use app\modules\quiz\models\Location;
use app\custom\widgets\backend\grid\LinkColumn;
use app\custom\widgets\backend\grid\ActionColumn;
use app\custom\widgets\backend\grid\ToggleColumn;

// @var $this yii\web\View
// @var $searchModel app\modules\quiz\models\LocationSearch
// @var $dataProvider yii\data\ActiveDataProvider

$this->title = Module::t('common', 'QUIZ_LOCATIONS');
$this->params['breadcrumbs'][] = $this->title;

$this->params['boxheader'] = [
    'icon' => 'fa-map-marker',
    'text' => $this->title,
];

?>
<div class="index">
    <p>
        <?php echo Html::a(Module::t('common', 'QUIZ_LOCATION_CREATE'), ['create'], ['class' => 'btn btn-success']); ?>
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
                'attribute' => 'title',
                'class' => LinkColumn::class,
                'action' => 'update',
            ],

            [
                'attribute' => 'address',
                'class' => LinkColumn::class,
                'action' => 'update',
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
