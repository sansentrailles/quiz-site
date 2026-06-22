<?php declare(strict_types=1);

use app\modules\geo\Module;
use app\modules\geo\forms\backend\RouteForm;

/**
 * @var yii\web\View $this
 * @var RouteForm $model
 */

$this->title = Module::t('common', 'GEO_ROUTE_UPDATE');
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'GEO_ROUTES'), 'url' => ['/admin/geo/routes']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['boxheader'] = [
    'icon' => 'fa-map',
    'text' => $this->title,
];
?>
<div class="update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
