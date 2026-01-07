<?php

declare(strict_types=1);

namespace app\modules\quiz\controllers\frontend;

use app\modules\quiz\models\Quest;
use Yii;
use app\modules\quiz\controllers\common\Controller;
use app\modules\quiz\models\Quiz;
use yii\web\HttpException;

class DefaultController extends Controller
{
    public function actionView($url)
    {
        $quiz = $this->quizService->getByUrl($url);
        if ($quiz == null || $quiz->is_visible == Quiz::STATUS_INVISIBLE) {
            throw new HttpException(404, 'Квиз не найден');
        }

        return $this->render('view', [
            'quiz' => $quiz,
        ]);
    }
}
