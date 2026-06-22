<?php declare(strict_types=1);

use app\modules\geo\Module;
use app\modules\geo\forms\backend\RouteForm;
use app\modules\geo\models\Route;

/**
 * @var yii\web\View $this
 * @var RouteForm $model
 * @var Route $route
 */

$this->title = Module::t('common', 'GEO_ROUTE_UPDATE');
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'GEO_ROUTES'), 'url' => ['/admin/geo/routes']];
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'GEO_POINTS'), 'url' => ['/admin/geo/points', 'routeId' => $route->id]];
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
