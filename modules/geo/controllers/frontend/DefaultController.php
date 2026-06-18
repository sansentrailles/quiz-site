<?php

declare(strict_types=1);

namespace app\modules\geo\controllers\frontend;

use app\modules\geo\controllers\common\Controller;
use yii\filters\VerbFilter;

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
}
