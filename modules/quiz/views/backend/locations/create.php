<?php declare(strict_types=1);

use app\modules\quiz\Module;

// @var $this yii\web\View
// @var $model app\modules\quiz\forms\backend\LocationForm

$this->title = Module::t('common', 'QUIZ_LOCATION_CREATE');
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'QUIZ_LOCATIONS'), 'url' => ['/admin/quiz/locations']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['boxheader'] = [
    'icon' => 'fa-map-marker',
    'text' => $this->title,
];
?>
<div class="create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
