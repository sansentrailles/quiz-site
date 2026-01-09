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
    public function actionIndex()
    {
        $actualQuizes = $this->quizService->getActualQuizes();
        $expiredQuizes = $this->quizService->getExpiredQuizes();

        $defaultSeo = [
            'title' => 'Все наши квизы | IQuiz Барные викторины и интеллектуальные игры',
            'description' => 'Квизы и интеллектуальные барные викторины Челябинска от IQuiz',
        ];

        return $this->render('index', [
            'actualQuizes' => $actualQuizes,
            'expiredQuizes' => $expiredQuizes,
            'defaultSeo' => $defaultSeo,
            'seoSection' => 'quiz',
        ]);
    }

    public function actionView($url)
    {
        $quiz = $this->quizService->getByUrl($url);
        if ($quiz == null || $quiz->is_visible == Quiz::STATUS_INVISIBLE) {
            throw new HttpException(404, 'Квиз не найден');
        }

        $defaultSeo = [
            'title' => 'Квиз '.$quiz->title.' | IQuiz Барные викторины и интеллектуальные игры',
            'description' => \yii\helpers\Html::encode($quiz->desc),
        ];

        $stats = null;
        if ($quiz->isExpired && count($quiz->participants) > 0) {
            $stats = $this->participantService->getStats($quiz->id);
        }

        return $this->render('view', [
            'quiz' => $quiz,
            'stats' => $stats,
            'defaultSeo' => $defaultSeo,
            'seoSection' => 'quiz',
        ]);
    }
}
