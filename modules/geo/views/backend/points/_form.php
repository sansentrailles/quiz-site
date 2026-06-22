<?php declare(strict_types=1);

use app\modules\geo\assets\MapAsset;
use yii\web\View;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\geo\Module;
use app\modules\geo\models\Route;

MapAsset::register($this);

/** @var View $this */
/** @var Route $model */
/** @var ActiveForm $form */

$cityName = "Челябинск";

?>

<div class="form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?php echo $form->field($model, 'is_visible')->checkbox(); ?>

        <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]); ?>

        <div class="form-group coords-picker">
            <div class="row">
                <div class="col-lg-6">
                    <div class="coords-picker-map" id="map-picker" style="width: 100%; height: 400px"></div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group" >
                        <?= Html::hiddenInput('', $cityName, ['class' => 'coords-picker-city']) ?>

                        <?= Html::button(Module::t('common', 'LOCATION_SEARCH'), ['class' => 'btn bg-olive coords-picker-search-btn']) ?>
                    </div>

                    <div class="form-group">
                        <?= Html::label(Module::t('common', 'LOCATION_SEARCH_BY_ADDRESS'), 'search-by-address', ['class' => 'control-label']) ?>
                        <?= Html::textInput('', '', ['class' => 'form-control coords-picker-address']) ?>
                    </div>

                    <?= $form->field($model, 'latitude')->textInput(['maxlength' => true, 'class' => "form-control coords-picker-latitude"]) ?>

                    <?= $form->field($model, 'longitude')->textInput(['maxlength' => true, 'class' => "form-control coords-picker-longitude"]) ?>

                </div>
            </div>
        </div>

        <div class="form-group">
            <?php echo Html::submitButton($model->isNewRecord ? Module::t('common', 'BUTTON_CREATE') : Module::t('common', 'BUTTON_UPDATE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
