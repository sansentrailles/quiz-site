<?php declare(strict_types=1);

use yii\web\View;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\modules\quiz\Module;
use app\modules\quiz\models\Label;

/** @var View $this */
/** @var Label $model */
/** @var ActiveForm $form */

?>

<div class="form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?php echo $form->field($model, 'quiz_id')->hiddenInput()->label(false); ?>

        <?php echo $form->field($model, 'team_id')->dropDownList(ArrayHelper::map($teams, 'id', 'title'), [
            'prompt' => 'Укажите команду',
        ]); ?>

        <?php echo $form->field($model, 'persons')->textInput(); ?>

        <?php echo $form->field($model, 'points')->textInput(); ?>

        <?php echo $form->field($model, 'place')->textInput(); ?>

        <div class="form-group">
            <?php echo Html::submitButton($model->isNewRecord ? Module::t('common', 'BUTTON_CREATE') : Module::t('common', 'BUTTON_UPDATE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
