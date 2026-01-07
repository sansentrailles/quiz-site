<?php declare(strict_types=1);

use app\modules\quiz\Module;

// @var $this yii\web\View
// @var $model app\modules\quiz\forms\backend\FaqItemForm

$this->title = Module::t('common', 'QUIZ_FAQ_ITEM_CREATE');
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'QUIZ_FAQ_ITEMS'), 'url' => ['/admin/quiz/faq-items']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['boxheader'] = [
    'icon' => 'fa-question',
    'text' => $this->title,
];
?>
<div class="create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
