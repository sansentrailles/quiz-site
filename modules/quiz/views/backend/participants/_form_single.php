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

?>

<div class="form">

    <?php $form = ActiveForm::begin([
        'action' => Url::to(['/admin/quiz/participants/apply-single', 'bookingId' => $booking->id]),
        'options' => ['enctype' => 'multipart/form-data']]
    ); ?>

        <?php echo $form->field($model, 'quiz_id')->hiddenInput()->label(false); ?>

        <?php echo $form->field($model, 'team_id')->dropDownList(ArrayHelper::map($teams, 'id', 'title'), [
            'prompt' => 'Укажите команду',
        ])->hint('<span class="text-green">Доступные команды, которые открыты для добавления участников и имеют меньше 10 человек</span>'); ?>

        <?php echo $form->field($model, 'comment')->textarea([
            'rows' => 6,
        ]); ?>

        <div class="form-group">
            <?php echo Html::submitButton($model->isNewRecord ? Module::t('common', 'BUTTON_ADD_PERSONS_TO_COMMAND') : Module::t('common', 'BUTTON_UPDATE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
