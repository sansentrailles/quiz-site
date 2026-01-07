<?php declare(strict_types=1);

use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\modules\quiz\Module;
use dosamigos\tinymce\TinyMce;
use app\modules\quiz\models\FaqItem;
use app\custom\widgets\backend\delete\Delete;
use dosamigos\datepicker\DatePicker;

/** @var View $this */
/** @var FaqItem $model */
/** @var ActiveForm $form */

?>

<div class="form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?php echo $form->field($model, 'is_visible')->checkbox(); ?>

        <?php echo $form->field($model, 'question')->textarea(['rows' => 4]); ?>

        <?php echo $form->field($model, 'answer')->widget(TinyMce::class, [
            'options' => ['rows' => 10],
            'language' => Yii::$app->language,
            'clientOptions' => [
                'plugins' => [
                    'advlist autolink lists link charmap hr preview pagebreak',
                    'wordcount code fullscreen nonbreaking',
                    'save insertdatetime contextmenu paste',
                ],
                'toolbar' => 'undo redo | styleselect | bold italic ',
            ],
        ]); ?>

        <div class="form-group">
            <?php echo Html::submitButton($model->isNewRecord ? Module::t('common', 'BUTTON_CREATE') : Module::t('common', 'BUTTON_UPDATE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
