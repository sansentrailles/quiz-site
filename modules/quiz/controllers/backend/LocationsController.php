<?php

declare(strict_types=1);

namespace app\modules\quiz\controllers\backend;

use app\modules\quiz\controllers\common\Controller;
use app\modules\quiz\forms\backend\LocationForm as Form;
use app\modules\quiz\forms\backend\search\LocationSearch as SearchModel;
use Exception;
use Yii;
use yii\filters\VerbFilter;

class LocationsController extends Controller
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
            $this->locationService->save($model);

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $post = Yii::$app->request->post();
        $entity = $this->locationService->find((int)$id);
        $model = new Form($entity);

        if ($model->load($post) && $model->validate()) {
            $this->locationService->save($model);

            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->locationService->findOrFail((int)$id);
        $this->locationService->delete($id);

        return $this->redirect(['index']);
    }
}
