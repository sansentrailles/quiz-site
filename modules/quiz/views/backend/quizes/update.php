<?php declare(strict_types=1);

use app\modules\quiz\Module;

// @var $this yii\web\View

$this->title = Module::t('common', 'QUIZ_UPDATE');
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'QUIZES'), 'url' => ['/admin/quiz/quizes']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['boxheader'] = [
    'icon' => 'fa-question',
    'text' => $this->title,
];
?>
<div class="update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'labels' => $labels,
        'locations' => $locations,
    ]); ?>

</div>
