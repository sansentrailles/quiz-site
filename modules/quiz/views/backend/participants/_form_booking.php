<?php declare(strict_types=1);

use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\modules\quiz\Module;
use app\modules\quiz\models\Label;

/** @var View $this */
/** @var Label $model */
/** @var ActiveForm $form */

$label = "Добавить участника";
$action = Url::to(['/admin/quiz/participants/add-participant', 'bookingId' => $booking->id]);
if ($team === null) {
    $action = Url::to(['/admin/quiz/participants/add-new-participant', 'bookingId' => $booking->id]);
}

?>

<div class="form">

    <?php $form = ActiveForm::begin([
        'action' => $action,
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

        <?php echo $form->field($model, 'quiz_id')->hiddenInput()->label(false); ?>

        <?php echo $form->field($model, 'is_opened')->checkbox(); ?>

        <?php if ($team === null) { ?>
            <div class="form-group">
                <?= Html::textInput('team_name', $booking->team_name, ['class' => 'form-control']) ?>
            </div>
        <?php } else { ?>
            <?php echo $form->field($model, 'team_id')->dropDownList(ArrayHelper::map($teams, 'id', 'title'), [
                'prompt' => 'Укажите команду',
            ]); ?>
        <?php } ?>

        <?php echo $form->field($model, 'name')->textInput(); ?>

        <?php echo $form->field($model, 'contact')->textInput(); ?>

        <?php echo $form->field($model, 'persons')->textInput(); ?>

        <?php echo $form->field($model, 'comment')->textarea([
            'rows' => 6,
        ]); ?>

        <?php if($team === null) { ?>
            <div class="form-group">
                <div class="text-red">Команда не найдена</div>
                <div class="text-red">Команда будет создана и добавлена как участник квиза</div>
            </div>
        <?php } ?>

        <div class="form-group">
            <?php echo Html::submitButton($label, ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
