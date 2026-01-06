<?php

declare(strict_types=1);

namespace app\modules\main\controllers\frontend;

use app\modules\main\controllers\common\Controller;
use Yii;


class MainController extends Controller
{
    public function actionIndex()
    {
        
        $quizes = $this->quizService->getVisible();

        return $this->render('index', [
            'quizes' => $quizes,
        ]);
    }
}
