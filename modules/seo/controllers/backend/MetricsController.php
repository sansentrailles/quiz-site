<?php

namespace app\modules\seo\controllers\backend;

use Yii;
use yii\base\Model;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use app\modules\seo\controllers\common\Controller;
use app\modules\seo\forms\backend\search\MetricSearch as SearchModel;
use app\modules\seo\forms\backend\MetricForm as Form;
use app\modules\seo\Module;

/**
 * Metrics controller for the `seo` module
 */
class MetricsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
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
            $this->metricService->save($model);

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $post = Yii::$app->request->post();
        $metric = $this->metricService->find($id);
        $model = new Form($metric);

        if ($model->load($post) && $model->validate()) {
            $this->metricService->save($model);

            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $metric = $this->metricService->findOrFail($id);
        $this->metricService->delete($id);

        return $this->redirect(['index']);
    }

    public function actionToggleVisible($id)
    {
        $this->guardRequestPostAjax();
        $state = $this->metricService->toggleVisible($id);

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

        $this->metricService->changeOrder($ords);
        Yii::$app->getSession()->setFlash('success', Module::t('common', 'ORD_SAVED_SUCCESS'));
        return $this->redirect($request->referrer);
    }
}
