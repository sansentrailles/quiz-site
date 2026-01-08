<?php

declare(strict_types=1);

namespace app\modules\quiz\controllers\backend;

use app\modules\quiz\controllers\common\Controller;
use app\modules\quiz\forms\backend\ParticipantForm as Form;
use app\modules\quiz\forms\backend\search\ParticipantSearch as SearchModel;
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

        $searchModel = new SearchModel();

        $dataProvider = $searchModel
            ->forQuiz($quizId)
            ->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'quiz' => $quiz,
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
}
