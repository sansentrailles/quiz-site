<?php declare(strict_types=1);

use app\modules\quiz\Module;

// @var $this yii\web\View
// @var $model app\modules\quiz\forms\backend\QuestForm

$this->title = Module::t('common', 'QUIZ_LABEL_CREATE');
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'QUIZ_LABELS'), 'url' => ['/admin/quiz/labels']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['boxheader'] = [
    'icon' => 'fa-tag',
    'text' => $this->title,
];
?>
<div class="create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
