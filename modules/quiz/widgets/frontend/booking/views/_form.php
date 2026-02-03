<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$persons = [
    1 => 1,
    2 => 2,
    3 => 3,
    4 => 4,
    5 => 5,
    6 => 6,
    7 => 7,
    8 => 8,
    9 => 9,
    10 => 10,
];

$formName = mb_strtolower($model::getName());

?>

<?php $form = ActiveForm::begin([
    'id' => 'quizBookingForm',
    'action' => $action,
    'enableClientValidation' => false,
    'enableClientScript' => false,
    'options' => [
        'class' => 'booking-form',
        'enctype' => 'multipart/form-data',
        'data-name' => $formName,
    ],
    'fieldConfig' => [],
]); ?>
    <?= Html::activeHiddenInput($model, 'quizId', [])?>

    <div class="checkbox-group">
        <?= Html::activeCheckbox($model, 'isSingle', [
            'label' => Html::decode($model->getAttributeLabel('isSingle')),
            'class' => 'checkbox-input',
            'data-single-checkbox' => true,
            'labelOptions' => [
                'class' => 'checkbox-label',
            ],
            'uncheck' => 0,
        ]) ?>
    </div>

    <div class="form-group">
        <?= Html::activeLabel($model, 'name', [
            'class' => 'form__label',
            'label' => Html::decode($model->getAttributeLabel('name'))
        ]) ?>
        <?= Html::activeTextInput($model, 'name', [
            'class' => 'form__control',
        ])?>
        <span class="form-error-message" id="<?= $formName ?>-name-error"><i class="fas fa-exclamation-circle"></i> <span></span></span>
    </div>

    <div class="form-group">
        <?= Html::activeLabel($model, 'contact', [
            'class' => 'form__label',
            'label' => Html::decode($model->getAttributeLabel('contact'))
        ]) ?>
        <?= Html::activeTextInput($model, 'contact', [
            'class' => 'form__control',
        ])?>
        <span class="form-error-message" id="<?= $formName ?>-contact-error"><i class="fas fa-exclamation-circle"></i> <span></span></span>
    </div>

    <div class="form-group">
        <?= Html::activeLabel($model, 'teamName', [
            'class' => 'form__label',
            'label' => Html::decode($model->getAttributeLabel('teamName'))
        ]) ?>
        <?= Html::activeTextInput($model, 'teamName', [
            'class' => 'form__control',
            'data-team-name' => true,
        ])?>
        <span class="form-error-message" id="<?= $formName ?>-teamname-error"><i class="fas fa-exclamation-circle"></i> <span></span></span>
    </div>

    <div class="form-group">
        <?= Html::activeLabel($model, 'persons', [
            'class' => 'form__label',
            'label' => Html::decode($model->getAttributeLabel('persons'))
        ]) ?>
        <?= Html::activeDropDownList($model, 'persons', $persons, [
            'class' => 'form__control',
        ])?>
        <span class="form-error-message" id="<?= $formName ?>-persons-error"><i class="fas fa-exclamation-circle"></i> <span></span></span>
    </div>

    <div class="form-group">
        <?= Html::activeLabel($model, 'holiday', [
            'class' => 'form__label',
            'label' => Html::decode($model->getAttributeLabel('holiday'))
        ]) ?>
        <?= Html::activeTextInput($model, 'holiday', [
            'class' => 'form__control',
        ])?>
    </div>

    <div class="checkbox-group">
        <?= Html::activeCheckbox($model, 'isOpened', [
            'label' => Html::decode($model->getAttributeLabel('isOpened')),
            'class' => 'checkbox-input',
            'labelOptions' => [
                'class' => 'checkbox-label',
            ],
            'uncheck' => 0,
        ]) ?>
    </div>

    <div class="checkbox-group">
        <?= Html::activeCheckbox($model, 'isAccept', [
            'label' => Html::decode($model->getAttributeLabel('isAccept')),
            'class' => 'checkbox-input',
            'labelOptions' => [
                'class' => 'checkbox-label',
            ],
            'uncheck' => null,
        ]) ?>
        <span class="form-error-message" id="<?= $formName ?>-isaccept-error">
            <i class="fas fa-exclamation-circle"></i> <span></span>
        </span>
    </div>

    <button type="submit" class="btn-signup" id="submitBtn">
        <i class="fas fa-paper-plane"></i> Отправить заявку
    </button>
<?php ActiveForm::end(); ?>
