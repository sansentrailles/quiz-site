<?php

declare(strict_types=1);

namespace app\modules\geo\controllers\backend;

use app\modules\geo\controllers\common\Controller;
use app\modules\geo\forms\backend\PointForm as Form;
use app\modules\geo\forms\backend\search\PointSearch as SearchModel;
use Yii;
use app\modules\geo\Module;
use yii\filters\VerbFilter;

class PointsController extends Controller
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

    public function actionIndex(int $routeId)
    {
        $route = $this->routeService->findOrFail((int)$routeId);

        $searchModel = new SearchModel();

        $dataProvider = $searchModel
            ->forRoute($routeId)
            ->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'route' => $route,
        ]);
    }

    public function actionCreate(int $routeId)
    {
        $route = $this->routeService->findOrFail((int)$routeId);

        $post = Yii::$app->request->post();
        $model = new Form();
        $model->setRoute($routeId);

        if ($model->load($post) && $model->validate()) {
            $this->pointService->save($model);

            return $this->redirect(['index', 'routeId' => $routeId]);
        }

        return $this->render('create', [
            'model' => $model,
            'route' => $route,
        ]);
    }

    public function actionUpdate(int $id)
    {
        $post = Yii::$app->request->post();
        $entity = $this->pointService->find((int)$id);
        $model = new Form($entity);

        if ($model->load($post) && $model->validate()) {
            $this->pointService->save($model);

            return $this->redirect(['index', 'routeId' => $model->route_id]);
        }

        return $this->render('update', [
            'model' => $model,
            'route' => $entity->route,
        ]);
    }

    public function actionDelete(int $id)
    {
        $entity = $this->pointService->findOrFail((int)$id);
        $routeId = $entity->route_id;
        $this->pointService->delete($id);

        return $this->redirect(['index', 'routeId' => $routeId]);
    }

    public function actionToggleVisible(int $id)
    {
        $this->guardRequestPostAjax();
        $state = $this->pointService->toggleVisible($id);

        return [
            'status' => 'ok',
            'value' => $state,
            'message' => 'The requested photo has been switched successfully',
        ];
    }

    public function actionSort()
    {
        $request = Yii::$app->request;
        $ords = $request->post('orders');

        if (empty($ords)) {
            return $this->redirect($request->referrer);
        }

        $this->pointService->changeOrder($ords);
        Yii::$app->getSession()->setFlash('success', Module::t('common', 'ORD_SAVED_SUCCESS'));
        return $this->redirect($request->referrer);
    }
}
