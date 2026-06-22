<?php declare(strict_types=1);

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\geo\Module;
use app\modules\geo\models\Route;
use app\modules\geo\models\Point;
use app\custom\widgets\backend\grid\LinkColumn;
use app\custom\widgets\backend\grid\ActionColumn;
use app\custom\widgets\backend\grid\ToggleColumn;
use app\custom\widgets\backend\grid\InputColumn;

/**
 * @var yii\web\View $this
 * @var app\modules\geo\forms\backend\search\PointSearch $searchModel
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var Route $route
 */

$this->title = Module::t('common', 'GEO_POINTS');
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'GEO_ROUTES'), 'url' => ['/admin/geo/routes']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['boxheader'] = [
    'icon' => 'fa-map',
    'text' => $this->title,
];

?>

<div class="index">
    <p>
        <?php echo Html::a(Module::t('common', 'GEO_POINT_CREATE'), ['create', 'routeId' => $route->id], ['class' => 'btn btn-success']); ?>
    </p>

    <?= Html::beginForm(['points/sort'], 'post', ['enctype' => 'multipart/form-data']) ?>
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
                    'attribute' => 'ord',
                    'headerOptions' => ['width' => '5%'],
                    'contentOptions' => ['style' => 'text-align: center'],
                    'class' => InputColumn::class,
                    'name' => 'orders',
                ],

                [
                    'class' => ToggleColumn::class,
                    'contentOptions' => ['style' => 'text-align: center'],
                    'attribute' => 'is_visible',
                    'action' => 'toggle-visible',
                    'filter' => [
                        Point::STATUS_INVISIBLE => Module::t('common', 'INACTIVE'),
                        Point::STATUS_VISIBLE => Module::t('common', 'ACTIVE'),
                    ],
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
</div>
