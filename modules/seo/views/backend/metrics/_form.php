<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\modules\seo\Module;
use app\modules\seo\models\Metric;

/* @var $this yii\web\View */
/* @var $model app\modules\seo\models\Metric */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($model, 'is_visible')->checkbox() ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'place')->dropDownList(Metric::getPlaces(), [
            'prompt' => 'Укажите расположение кода'
        ]) ?>

        <?= $form->field($model, 'code')->textarea(['rows' => 15]) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Module::t('common', 'BUTTON_CREATE') : Module::t('common', 'BUTTON_UPDATE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
