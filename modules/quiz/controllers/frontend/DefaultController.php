<?php

declare(strict_types=1);

namespace app\modules\quiz\controllers\frontend;

use Yii;
use app\modules\quiz\controllers\common\Controller;
use app\modules\quiz\models\Quiz;
use yii\web\HttpException;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use app\modules\quiz\forms\frontend\QuizBookingForm;

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

    public function actionRating()
    {
        $defaultSeo = [
            'title' => 'Рейтинг команд квизов от IQuiz | IQuiz Барные викторины и интеллектуальные игры',
            'description' => 'Страница рейтинга команд квизов и интеллектуальные барных викторин Челябинска от IQuiz',
        ];


        $data = $this->participantService->getRating();
        $provider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 15,
                'pageSizeParam' => false,
            ],
            'sort' => false,
        ]);

        return $this->render('rating', [
            'defaultSeo' => $defaultSeo,
            'seoSection' => 'rating',
            'provider' => $provider,
            'stats' => [
                'monthQuizes' => $this->quizService->getCurrentMonthQuizCount(),
                'teamsCount' => count($this->teamService->getAll()),
                'expiredQuizesCount' => count($this->quizService->getExpiredQuizes()),
                'totalPoints' => $this->participantService->getTotalPoints(),
            ],
        ]);
    }

    public function actionBooking()
    {
        $this->setJsonResponse();

        $post = Yii::$app->request->post();
        $model = new QuizBookingForm();

        if ($model->load($post) && $model->validate()) {
            $this->quizBookingService->booking($model);

            return [
                'success' => true,
                'message' => 'Заявка успешно отправлена',
            ];
        } else {
            return [
                'success' => false,
                'name' => $model->name,
                'persons' => $model->persons,
                'teamName' => $model->teamName,
                'isAccept' => $model->isAccept,
                'errors' => \yii\widgets\ActiveForm::validate($model),
            ];
        }
    }
}
