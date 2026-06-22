<?php declare(strict_types=1);

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use app\modules\geo\Module;
use app\modules\geo\models\Route;
use app\custom\widgets\backend\grid\LinkColumn;
use app\custom\widgets\backend\grid\ActionColumn;
use app\custom\widgets\backend\grid\ToggleColumn;

/**
 * @var yii\web\View $this
 * @var app\modules\geo\forms\backend\search\RouteSearch $searchModel
 * @var $dataProvider yii\data\ActiveDataProvider
 */

$this->title = Module::t('common', 'GEO_ROUTES');
$this->params['breadcrumbs'][] = $this->title;

$this->params['boxheader'] = [
    'icon' => 'fa-map',
    'text' => $this->title,
];

?>

<div class="index">
    <p>
        <?php echo Html::a(Module::t('common', 'GEO_ROUTE_CREATE'), ['create'], ['class' => 'btn btn-success']); ?>
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
                'headerOptions' => ['width' => '10%'],
                'label' => Module::t('common', 'GEO_POINTS'),
                'format' => 'raw',
                'value' => function($model) {
                    $url = Url::to(['/admin/geo/points', 'routeId' => $model->id]);
                    return Html::a(Module::t('common', 'GEO_POINTS'), $url);
                }
            ],

            [
                'class' => ToggleColumn::class,
                'contentOptions' => ['style' => 'text-align: center'],
                'attribute' => 'is_visible',
                'action' => 'toggle-visible',
                'filter' => [
                    Route::STATUS_INVISIBLE => Module::t('common', 'INACTIVE'),
                    Route::STATUS_VISIBLE => Module::t('common', 'ACTIVE'),
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
