<?php declare(strict_types=1);

use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\modules\quiz\Module;
use dosamigos\tinymce\TinyMce;
use app\modules\quiz\models\Quiz;
use app\custom\widgets\backend\delete\Delete;
use dosamigos\datepicker\DatePicker;

/** @var View $this */
/** @var Quiz $model */
/** @var ActiveForm $form */

?>

<div class="form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
        'fieldConfig' => [
            'hintOptions' => ['style' => 'color: rgb(3, 71, 30);'],
        ],
    ]); ?>

        <?php echo $form->field($model, 'is_visible')->checkbox(); ?>

        <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]); ?>

        <?php echo $form->field($model, 'price')->textInput(); ?>

        <?php echo $form->field($model, 'url')->textInput(['maxlength' => true]); ?>

        <?php echo $form->field($model, 'location_id')->dropDownList(ArrayHelper::map($locations, 'id', 'title'), [
            'prompt' => 'Выбрать локацию',
        ]); ?>

        <?php echo $form->field($model, 'desc')->textarea(['rows' => 8]); ?>

        <div class="row">
            <div class="form-group">
                <div class="col-md-6">
                    <?= $form->field($model, 'date')->widget(
                        DatePicker::class, [
                        'language' => 'ru',
                        'clientOptions' => [
                            'autoclose' => true,
                            'dateFormat' => 'dd.mm.yyyy'
                        ]
                    ]);?>
                </div>

                <div class="col-md-6">
                    <?php echo $form->field($model, 'time')->textInput(); ?>
                </div>
            </div>
        </div>

        <?php echo $form->field($model, 'text')->widget(TinyMce::class, [
            'options' => ['rows' => 15],
            'language' => Yii::$app->language,
            'clientOptions' => [
                'plugins' => [
                    'advlist autolink lists link charmap hr preview pagebreak',
                    'wordcount code fullscreen nonbreaking',
                    'save insertdatetime contextmenu paste',
                ],
                'toolbar' => 'undo redo | styleselect | bold italic | bullist numlist',
            ],
        ]); ?>

        <?php echo $form->field($model, 'items')->textarea(['rows' => 10])
            ->hint('<span class="text-green">Каждый пункт на отдельной строке</span>')
            ;
        ?>

        <?php echo $form->field($model, 'labels[]')->checkboxList(ArrayHelper::map($labels, 'id', 'title'), ['multiple' => true, 'size' => '15', 'separator' => '<br>']); ?>

        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <?php echo $form->field($model, 'imageFile')->fileInput(); ?>

                    <?php if ($model->image) { ?>
                        <div class="row" data-removable>
                            <div class="col-md-6">
                                <img src="<?php echo $model->imagePath; ?>" alt="" class='img-responsive'>
                            </div>
                            <div class="col-md-6">
                                <?php echo Delete::widget([
                                    'url' => Url::to(['/admin/quiz/quizes/delete-image', 'id' => $model->id]),
                                ]); ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <div class="col-md-6">
                </div>
            </div>
        </div>

        <div class="form-group">
            <?php echo Html::submitButton($model->isNewRecord ? Module::t('common', 'BUTTON_CREATE') : Module::t('common', 'BUTTON_UPDATE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
