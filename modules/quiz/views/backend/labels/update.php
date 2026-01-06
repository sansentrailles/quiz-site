<?php declare(strict_types=1);

use app\modules\quiz\Module;

// @var $this yii\web\View

$this->title = Module::t('common', 'QUIZ_LABEL_UPDATE');
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'QUIZE_LABELS'), 'url' => ['/admin/quiz/labels']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['boxheader'] = [
    'icon' => 'fa-tag',
    'text' => $this->title,
];
?>
<div class="update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
