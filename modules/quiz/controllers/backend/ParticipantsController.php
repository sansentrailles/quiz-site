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

    public function actionApplyBooking($id) {
        $booking = $this->quizBookingService->findOrFail((int)$id);

        $model = new Form();
        $model->setQuiz($booking->quiz_id);
        $model->persons = $booking->persons;
        $model->is_opened = $booking->is_opened;
        $model->name = $booking->name;
        $model->contact = $booking->contact;

        if ($booking->is_single) {
            $model->comment .= "\nДобавлен участник: ".$booking->name."(".$booking->contact.")";

            return $this->render('apply-single', [
                'model' => $model,
                'booking' => $booking,
                'teams' => $this->teamService->getAvailableTeams($booking->quiz_id),
            ]);
        }

        $team = $this->teamService->getByName($booking->team_name);
        if ($team) {
            $model->team_id = $team->id;
        }
        
        return $this->render('apply-booking', [
            'model' => $model,
            'booking' => $booking,
            'team' => $team,
            'teams' => $this->teamService->getAll(),
        ]);
    }

    public function actionApplySingle(int $bookingId)
    {
        $booking = $this->quizBookingService->findOrFail($bookingId);

        $model = new Form();
        $post = Yii::$app->request->post();
        $model->load($post);

        $participant = $this->participantService->getByRefs((int) $model->quiz_id, (int) $model->team_id);
        if ($participant === null) {
            Yii::$app->getSession()->setFlash('danger', Module::t('common', 'Произошла непредвиденная ошибка'));
            return $this->render('apply-single', [
                'model' => $model,
                'booking' => $booking,
                'teams' => $this->teamService->getAvailableTeams($booking->quiz_id),
            ]);
        }

        $model = new Form($participant);
        $model->persons += 1;

        if ($model->validate()) {
            $this->participantService->save($model);
            $this->quizBookingService->delete($booking->id);
            Yii::$app->getSession()->setFlash('success', 'Участник добавлен в команду - '.$participant->team->title);
            return $this->redirect(['index', 'quizId' => $booking->quiz_id]);
        }

        Yii::$app->getSession()->setFlash('danger', 'Произошла ошибка валидации');
        return $this->render('apply-single', [
            'model' => $model,
            'booking' => $booking,
            'teams' => $this->teamService->getAvailableTeams($booking->quiz_id),
        ]);
    }

    public function actionAddParticipant(int $bookingId)
    {
        $booking = $this->quizBookingService->findOrFail($bookingId);
        $model = new Form();
        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->validate()) {
            $this->participantService->save($model);
            $this->quizBookingService->delete($booking->id);

            Yii::$app->getSession()->setFlash('success', 'Участник добавлен');
            return $this->redirect(['index', 'quizId' => $model->quiz_id]);
        }

        Yii::$app->getSession()->setFlash('danger', 'Какая-то ошибка №122');
        return $this->redirect(['apply-booking', 'id' => $bookingId]);
    }

    public function actionAddNewParticipant(int $bookingId)
    {
        $booking = $this->quizBookingService->findOrFail($bookingId);

        $post = Yii::$app->request->post();
        $teamName = Yii::$app->request->post('team_name');

        $team = $this->teamService->createByName($teamName);
        if (!$team) {
            Yii::$app->getSession()->setFlash('warning', 'Не удалось создать команду - '.$teamName);
        }

        $model = new Form();
        $model->team_id = $team->id;

        if ($model->load($post) && $model->validate()) {
            $this->participantService->save($model);
            $this->quizBookingService->delete($booking->id);
            return $this->redirect(['index', 'quizId' => $model->quiz_id]);
        }

        Yii::$app->getSession()->setFlash('danger', 'Произошла непонятная ошибка валидации');
        return $this->render('apply-booking', [
            'model' => $model,
            'booking' => $booking,
            'team' => $team,
            'teams' => $this->teamService->getAll(),
        ]);
    }

    public function actionDeleteBooking($id)
    {
        $entity = $this->quizBookingService->findOrFail((int)$id);
        $quizId = $entity->quiz_id;
        $this->quizBookingService->delete($id);

        return $this->redirect(['index', 'quizId' => $quizId]);
    }
}
