<?php declare(strict_types=1);

use app\modules\quiz\Module;

// @var $this yii\web\View
// @var $model app\modules\quiz\forms\backend\ParticipantForm

$this->title = Module::t('common', 'QUIZ_PARTICIPANT_CREATE');
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'QUIZES'), 'url' => ['/admin/quiz/quizes']];
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'QUIZ_PARTICIPANTS'), 'url' => ['/admin/quiz/participants', 'quizId' => $model->quiz_id]];
$this->params['breadcrumbs'][] = $this->title;
$this->params['boxheader'] = [
    'icon' => 'fa-cubes',
    'text' => $this->title,
];
?>
<div class="create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'teams' => $teams,
    ]); ?>

</div>
