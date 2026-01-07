<?php declare(strict_types=1);

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\quiz\Module;
use app\modules\quiz\models\FaqItem;
use app\custom\widgets\backend\grid\LinkColumn;
use app\custom\widgets\backend\grid\ActionColumn;
use app\custom\widgets\backend\grid\ToggleColumn;
use app\custom\widgets\backend\grid\InputColumn;

// @var $this yii\web\View
// @var $searchModel app\modules\quiz\models\FaqItemSearch
// @var $dataProvider yii\data\ActiveDataProvider

$this->title = Module::t('common', 'QUIZ_FAQ_ITEMS');
$this->params['breadcrumbs'][] = $this->title;

$this->params['boxheader'] = [
    'icon' => 'fa-question',
    'text' => $this->title,
];

$seoSection = 'quiz';

?>
<div class="index">
    <p>
        <?php echo Html::a(Module::t('common', 'QUIZ_FAQ_ITEM_CREATE'), ['create'], ['class' => 'btn btn-success']); ?>
    </p>

    <?= Html::beginForm(['faq-items/sort'], 'post', ['enctype' => 'multipart/form-data']) ?>
        <?php echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'headerOptions' => ['width' => '5%'],
                ],

                [
                    'headerOptions' => ['width' => '30%'],
                    'attribute' => 'question',
                    'class' => LinkColumn::class,
                    'action' => 'update',
                ],

                [
                    'headerOptions' => ['width' => '30%'],
                    'attribute' => 'answer',
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
                        FaqItem::STATUS_INVISIBLE => Module::t('common', 'INVISIBLE'),
                        FaqItem::STATUS_VISIBLE => Module::t('common', 'VISIBLE'),
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
