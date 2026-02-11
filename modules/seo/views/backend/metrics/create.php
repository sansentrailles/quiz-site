<?php

use yii\helpers\Html;
use app\modules\seo\Module;

/* @var $this yii\web\View */
/* @var $model app\modules\seo\forms\backend\MetricForm */

$this->title = Module::t('common', 'METRIC_CREATE');
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'METRICS'), 'url' => ['/admin/seo/metrics']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['boxheader'] = [
    'icon' => 'fa-code',
    'text' => $this->title,
];
?>
<div class="create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
