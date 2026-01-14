<?php

declare(strict_types=1);

namespace app\modules\quiz\controllers\backend;

use app\modules\quiz\controllers\common\Controller;
use app\modules\quiz\Module;
use app\modules\quiz\forms\backend\ParticipantForm as Form;
use app\modules\quiz\forms\backend\search\ParticipantSearch as SearchModel;
use app\modules\quiz\forms\backend\search\QuizBookingSearch as BookingSearchModel;
use Yii;
use yii\filters\VerbFilter;

class ParticipantsController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'sort' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex($quizId)
    {
        $quiz = $this->quizService->findOrFail((int)$quizId);
        $quizBooking = $this->quizBookingService->find((int)$quizId);

        $searchModel = new SearchModel();
        $bookingSearchModel = new BookingSearchModel();

        $dataProvider = $searchModel
            ->forQuiz($quizId)
            ->search(Yii::$app->request->queryParams);

        $bookingDataProvider = null;
        $bookingDataProvider = $bookingSearchModel
            ->forQuiz($quizId)
            ->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'bookingSearchModel' => $bookingSearchModel,
            'bookingDataProvider' => $bookingDataProvider,
            'dataProvider' => $dataProvider,
            'quiz' => $quiz,
            'quizBooking' => $quizBooking,
        ]);
    }

    public function actionCreate($quizId)
    {
        $quiz = $this->quizService->findOrFail((int)$quizId);

        $post = Yii::$app->request->post();
        $model = new Form();
        $model->setQuiz($quizId);

        if ($model->load($post) && $model->validate()) {
            $this->participantService->save($model);

            return $this->redirect(['index', 'quizId' => $quizId]);
        }

        return $this->render('create', [
            'model' => $model,
            'quiz' => $quiz,
            'teams' => $this->teamService->getAll(),
        ]);
    }

    public function actionUpdate($id)
    {
        $post = Yii::$app->request->post();
        $entity = $this->participantService->find((int)$id);
        $model = new Form($entity);

        if ($model->load($post) && $model->validate()) {
            $this->participantService->save($model);

            return $this->redirect(['index', 'quizId' => $model->quiz_id]);
        }

        return $this->render('update', [
            'model' => $model,
            'quiz' => $entity->quiz,
            'teams' => $this->teamService->getAll(),
        ]);
    }

    public function actionDelete($id)
    {
        $entity = $this->participantService->findOrFail((int)$id);
        $quizId = $entity->quiz_id;
        $this->participantService->delete($id);

        return $this->redirect(['index', 'quizId' => $quizId]);
    }

    public function actionSavePoints()
    {
        $request = Yii::$app->request;
        $points = $request->post('points_list');
        $places = $request->post('places');

        if (empty($points)) {
            return $this->redirect($request->referrer);
        }

        $this->participantService->savePoints($points, $places);
        Yii::$app->getSession()->setFlash('success', Module::t('common', 'POINTS_SAVED_SUCCESS'));
        return $this->redirect($request->referrer);
    }

    public function actionSetPlaces()
    {
        $request = Yii::$app->request;
        $quizId = $request->post('quizId');
        $this->participantService->setPlacesByQuiz((int) $quizId);
        Yii::$app->getSession()->setFlash('success', Module::t('common', 'PLACES_SAVED_SUCCESS'));
        return $this->redirect($request->referrer);
    }
}
