<?php declare(strict_types=1);

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\quiz\Module;
use app\modules\quiz\models\Label;
use app\custom\widgets\backend\grid\LinkColumn;
use app\custom\widgets\backend\grid\ActionColumn;
use app\custom\widgets\backend\grid\ToggleColumn;

// @var $this yii\web\View
// @var $searchModel app\modules\quiz\models\LabelSearch
// @var $dataProvider yii\data\ActiveDataProvider

$this->title = Module::t('common', 'QUIZ_LABELS');
$this->params['breadcrumbs'][] = $this->title;

$this->params['boxheader'] = [
    'icon' => 'fa-tag',
    'text' => $this->title,
];

$seoSection = 'quiz';

?>
<div class="index">
    <p>
        <?php echo Html::a(Module::t('common', 'QUIZ_LABEL_CREATE'), ['create'], ['class' => 'btn btn-success']); ?>
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
                'headerOptions' => ['width' => '5%'],
                'class' => ActionColumn::class,
                'contentOptions' => ['style' => 'text-align: center;'],
            ],
        ],
    ]); ?>
    <?php echo Html::endForm(); ?>
</div>
