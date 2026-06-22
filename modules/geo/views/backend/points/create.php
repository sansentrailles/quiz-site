<?php declare(strict_types=1);

use app\modules\geo\Module;
use app\modules\geo\forms\backend\PointForm;
use app\modules\geo\models\Route;

/**
 * @var yii\web\View $this
 * @var PointForm $model
 * @var Route $route
 */

$this->title = Module::t('common', 'GEO_POINT_CREATE');
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'GEO_ROUTES'), 'url' => ['/admin/geo/routes']];
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'GEO_POINTS'), 'url' => ['/admin/geo/points', 'routeId' => $route->id]];
$this->params['breadcrumbs'][] = $this->title;
$this->params['boxheader'] = [
    'icon' => 'fa-map',
    'text' => $this->title,
];
?>
<div class="create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
