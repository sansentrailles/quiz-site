<?php

declare(strict_types=1);

namespace app\modules\geo\controllers\frontend;

use app\modules\geo\controllers\common\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use app\modules\geo\models\Route;

class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'booking' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $this->layout = '@app/views/layouts/frontend/geo.php';

        return $this->render('index');
    }

    public function actionRouter()
    {
        $this->layout = '@app/views/layouts/frontend/router.php';

        return $this->render('router');
    }

    public function actionRoute($id)
    {
        $this->layout = '@app/views/layouts/frontend/route_points.php';

        $route = $this->routeService->find((int) $id);
        if ($route === null || $route->is_visible == Route::STATUS_INVISIBLE) {
            throw new NotFoundHttpException('Route not found');
        }

        return $this->render('route_points', [
            'route' => $route,
        ]);
    }
}
