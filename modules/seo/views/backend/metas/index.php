<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use app\modules\seo\models\MetaTag;
use app\modules\seo\Module;
use app\custom\widgets\backend\grid\ToggleColumn;
use app\custom\widgets\backend\grid\InputColumn;
use app\custom\widgets\backend\grid\ActionColumn;
use app\custom\widgets\backend\grid\ImageColumn;
use app\custom\widgets\backend\grid\LinkColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\seo\models\MetaTagSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('common', 'META_TAGS');
$this->params['breadcrumbs'][] = $this->title;

$this->params['boxheader'] = [
    'icon' => 'fa-code',
    'text' => $this->title,
];

?>

<div class="index">
    <p>
        <?= Html::a(Module::t('common', 'META_TAG_CREATE'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['width' => '5%'],
            ],

            [
                'attribute' => 'name',
                'class' => LinkColumn::class,
                'action' => 'update',
            ],

            [
                'attribute' => 'content',
                'class' => LinkColumn::class,
                'action' => 'update',
            ],

            [
                'class' => ToggleColumn::class,
                'contentOptions' => ['style' => 'text-align: center'],
                'attribute' => 'is_visible',
                'action' => 'toggle-visible',
                'filter' => [
                    MetaTag::STATUS_INVISIBLE => Module::t('common', 'INVISIBLE'),
                    MetaTag::STATUS_VISIBLE => Module::t('common', 'VISIBLE'),
                ],
            ],

            [
                'headerOptions' => ['width' => '5%'],
                'class' => ActionColumn::class,
                'contentOptions' => ['style' => 'text-align: center;'],
            ],
        ],
    ]); ?>

</div>
