<?php

use yii\helpers\Html;
use app\modules\seo\Module;

/* @var $this yii\web\View */

$this->title = Module::t('common', 'METRIC_UPDATE');
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'METRICS'), 'url' => ['/admin/seo/metrics/index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['boxheader'] = [
    'icon' => 'fa-code',
    'text' => $this->title,
];
?>
<div class="update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
