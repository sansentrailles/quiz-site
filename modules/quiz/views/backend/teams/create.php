<?php declare(strict_types=1);

use app\modules\quiz\Module;

// @var $this yii\web\View
// @var $model app\modules\quiz\forms\backend\TeamForm

$this->title = Module::t('common', 'QUIZ_TEAM_CREATE');
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'QUIZ_LABELS'), 'url' => ['/admin/quiz/teams']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['boxheader'] = [
    'icon' => 'fa-users',
    'text' => $this->title,
];
?>
<div class="create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
