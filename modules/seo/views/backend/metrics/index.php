<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use app\modules\seo\models\Metric;
use app\modules\seo\Module;
use app\custom\widgets\backend\grid\ToggleColumn;
use app\custom\widgets\backend\grid\InputColumn;
use app\custom\widgets\backend\grid\ActionColumn;
use app\custom\widgets\backend\grid\ImageColumn;
use app\custom\widgets\backend\grid\LinkColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\seo\models\MetricSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('common', 'METRICS');
$this->params['breadcrumbs'][] = $this->title;

$this->params['boxheader'] = [
    'icon' => 'fa-code',
    'text' => $this->title,
];

?>

<div class="index">
    <p>
        <?= Html::a(Module::t('common', 'METRIC_CREATE'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= Html::beginForm(['metrics/sort'], 'post', ['enctype' => 'multipart/form-data']) ?>

        <?= GridView::widget([
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
                    'attribute' => 'place',
                    'value' => function($model) {
                        if ($model->place) {
                            return Metric::getPlaces()[$model->place];
                        }

                        return '';
                    },
                    'filter' => Metric::getPlaces(),
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
                        Metric::STATUS_INVISIBLE => Module::t('common', 'INVISIBLE'),
                        Metric::STATUS_VISIBLE => Module::t('common', 'VISIBLE'),
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

    <?= Html::endForm(); ?>
</div>
