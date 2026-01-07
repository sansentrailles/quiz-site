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

        $defaultSeo = [
            'title' => 'Квизы в Челябинске - IQuiz | Барные викторины и интеллектуальные игры',
            'description' => 'IQuiz - проводим лучшие барные квизы в Челябинске. Интеллектуальные игры, вечерние викторины, корпоративные мероприятия. Записывайтесь на квизы онлайн!',
            'keywords' => 'квизы Челябинск, барные квизы, интеллектуальные игры, викторины в барах, iquiz Челябинск, квизы в барах, вечерние квизы, командные викторины, корпоративные квизы, тематические квизы, музыкальные квизы, киновикторины, развлечения Челябинск, барные игры',
        ];

        return $this->render('index', [
            'quizes' => $quizes,
            'defaultSeo' => $defaultSeo,
            'seoSection' => 'main',
        ]);
    }

    public function actionMaintance()
    {
        $defaultSeo = [
            'title' => 'Страница в разработке | Квизы в Челябинске - IQuiz | Барные викторины и интеллектуальные игры',
            'description' => 'IQuiz - проводим лучшие барные квизы в Челябинске. Интеллектуальные игры, вечерние викторины, корпоративные мероприятия. Записывайтесь на квизы онлайн!',
        ];

        return $this->render('maintance', [
            'defaultSeo' => $defaultSeo,
            'seoSection' => 'maintance',
        ]);
    }
}
