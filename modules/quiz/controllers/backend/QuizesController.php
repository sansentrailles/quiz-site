<?php

declare(strict_types=1);

namespace app\modules\quiz\controllers\backend;

use app\modules\quiz\controllers\common\Controller;
use app\modules\quiz\forms\backend\QuizForm as Form;
use app\modules\quiz\forms\backend\search\QuizSearch as SearchModel;
use Exception;
use Yii;
use yii\filters\VerbFilter;

class QuizesController extends Controller
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

    public function actionIndex()
    {
        $searchModel = new SearchModel();

        $dataProvider = $searchModel
            ->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $post = Yii::$app->request->post();
        $model = new Form();

        if ($model->load($post) && $model->validate()) {
            $this->quizService->save($model);

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'labels' => $this->labelService->getAll(),
            'locations' => $this->locationService->getAll(),
        ]);
    }

    public function actionUpdate($id)
    {
        $post = Yii::$app->request->post();
        $entity = $this->quizService->find((int)$id);
        $model = new Form($entity);

        if ($model->load($post) && $model->validate()) {
            $this->quizService->save($model);

            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'labels' => $this->labelService->getAll(),
            'locations' => $this->locationService->getAll(),
        ]);
    }

    public function actionDelete($id)
    {
        $this->quizService->findOrFail((int)$id);
        $this->quizService->delete($id);

        return $this->redirect(['index']);
    }

    public function actionDeleteImage($id)
    {
        $this->guardRequestPostAjax();

        try {
            $this->quizService->deleteImage($id);
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => 'cannot remove the requested file',
            ];
        }

        return [
            'status' => 'ok',
            'message' => 'The requested file has been deleted successfully',
        ];
    }

    public function actionToggleVisible($id)
    {
        $this->guardRequestPostAjax();
        $state = $this->quizService->toggleVisible($id);

        return [
            'status' => 'ok',
            'value' => $state,
            'message' => 'The requested photo has been switched successfully',
        ];
    }
}
