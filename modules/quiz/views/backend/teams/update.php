<?php declare(strict_types=1);

use app\modules\quiz\Module;

// @var $this yii\web\View

$this->title = Module::t('common', 'QUIZ_TEAM_UPDATE');
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'QUIZ_TEAMS'), 'url' => ['/admin/quiz/teams']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['boxheader'] = [
    'icon' => 'fa-users',
    'text' => $this->title,
];
?>
<div class="update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
