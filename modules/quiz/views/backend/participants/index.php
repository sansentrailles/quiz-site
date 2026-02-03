<?php declare(strict_types=1);

use yii\helpers\Html;
use app\modules\quiz\Module;

// @var $this yii\web\View
// @var $searchModel app\modules\quiz\models\ParticipantSearch
// @var $dataProvider yii\data\ActiveDataProvider

$this->title = Module::t('common', 'QUIZ_PARTICIPANTS_TITLE').": ".$quiz->title ."(".date('d.m.Y', $quiz->date).")";
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'QUIZES'), 'url' => ['/admin/quiz/quizes']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['boxheader'] = [
    'icon' => 'fa-cubes',
    'text' => $this->title,
];

$seoSection = 'quiz';
$bookingCount = count($bookingDataProvider->getModels());
$colClass = $bookingCount > 0 ? 'col-md-6' : 'col-md-12';

?>
<div class="index">
    <div class="row">
        <div class="<?=  $colClass ?>">
            <?= $this->render('_index_participants', [
                'dataProvider' => $dataProvider,
                'searchModel'=> $searchModel,
                'quiz' => $quiz,
            ]) ?>
        </div>
        <?php if ($bookingCount > 0) { ?>
            <div class="col-md-6">
                <?= $this->render('_index_booking', [
                    'dataProvider' => $bookingDataProvider,
                    'searchModel'=> $bookingSearchModel,
                    'quiz' => $quiz,
                ]) ?>
            </div>
        <?php } ?>
    </div>

    <br>
    <div class="form-group mt-5">
        <?php if (count($dataProvider->getModels()) > 0) { ?>
            <?= Html::beginForm(['participants/set-places'], 'post', ['enctype' => 'multipart/form-data']) ?>
                <?= Html::hiddenInput('quizId', $quiz->id) ?>
                <div class="text-green">Если для команд заполненны заработанные баллы за квиз, нажмите кнопку "<?= Module::t('common', 'BUTTON_SET_PLACES') ?>" для распределения мест</div>
                <div class="text-green">Для корректировки мест, заполните корректные значения в поле "Место" в таблице</div>
                <div class="text-red">Рекомендуется запускать когда очки всех команд прописаны</div><br>
                <?= Html::submitButton(Module::t('common', 'BUTTON_SET_PLACES'), ['class' => 'btn btn-sm btn-warning']) ?>
            <?php echo Html::endForm(); ?>
        <?php } ?>
    </div>
</div>
