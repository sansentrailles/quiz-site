<?php

declare(strict_types=1);

namespace app\modules\main\controllers\frontend;

use app\modules\main\controllers\common\Controller;

class DefaultController extends Controller
{
    public function actionError()
    {
        $defaultSeo = [
            'title' => 'Страница не найдена | Квизы в Челябинске - IQuiz | Барные викторины и интеллектуальные игры',
            'description' => 'IQuiz - проводим лучшие барные квизы в Челябинске. Интеллектуальные игры, вечерние викторины, корпоративные мероприятия. Записывайтесь на квизы онлайн!',
        ];

        $exception  = \Yii::$app->getErrorHandler()->exception;
        return $this->render('error', [
            'exception' => $exception,
            'defaultSeo' => $defaultSeo,
            'seoSection' => 'error',
        ]);
    }
}
