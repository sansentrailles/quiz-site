<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\quiz\Module;
use app\modules\quiz\assets\QuizAsset;

QuizAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\modules\contacts\models\Branch */
/* @var $form yii\widgets\ActiveForm */
$index = 0;

$cityName = 'Челябинск';
$formName = \yii\helpers\StringHelper::basename(get_class($model));

?>

<div class="form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput() ?>

    <?= $form->field($model, 'address')->textInput() ?>

    <?= $form->field($model, 'desc')->textarea(['rows' => 3]) ?>

    <?= $form->field($model, 'workmode')->textarea(['rows' => 3]) ?>

    <?php /* =============================== */ ?>
    <div class="form-group coords-picker">
        <div class="row">
            <div class="col-lg-6">
                <div class="coords-picker-map" id="map-picker" style="width: 100%; height: 400px"></div>
            </div>

            <div class="col-lg-6">
                <div class="form-group" >
                    <?= Html::hiddenInput('', $cityName, ['class' => 'coords-picker-city']) ?>

                    <?= Html::button(Module::t('common', 'QUIZ_LOCATION_SEARCH'), ['class' => 'btn bg-olive coords-picker-search-btn']) ?>
                </div>

                <div class="form-group">
                    <?= Html::label(Module::t('common', 'QUIZ_LOCATION_SEARCH_BY_ADDRESS'), 'search-by-address', ['class' => 'control-label']) ?>
                    <?= Html::textInput('', '', ['class' => 'form-control coords-picker-address']) ?>
                </div>

                <?= $form->field($model, 'latitude')->textInput(['maxlength' => true, 'class' => "form-control coords-picker-latitude"]) ?>

                <?= $form->field($model, 'longitude')->textInput(['maxlength' => true, 'class' => "form-control coords-picker-longitude"]) ?>

            </div>
        </div>
    </div>

    <?php /* =============================== */ ?>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? Module::t('common', 'BUTTON_CREATE') : Module::t('common', 'BUTTON_UPDATE'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>