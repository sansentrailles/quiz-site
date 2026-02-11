<?php

namespace app\modules\seo\controllers\backend;

use Yii;
use yii\base\Model;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use app\modules\seo\controllers\common\Controller;
use app\modules\seo\forms\backend\search\MetaTagSearch as SearchModel;
use app\modules\seo\forms\backend\MetaTagForm as Form;
use app\modules\seo\Module;

/**
 * Metas controller for the `seo` module
 */
class MetasController extends Controller
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
            $this->metaTagService->save($model);

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $post = Yii::$app->request->post();
        $metaTag = $this->metaTagService->find($id);
        $model = new Form($metaTag);

        if ($model->load($post) && $model->validate()) {
            $this->metaTagService->save($model);

            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $metric = $this->metaTagService->findOrFail($id);
        $this->metaTagService->delete($id);

        return $this->redirect(['index']);
    }

    public function actionToggleVisible($id)
    {
        $this->guardRequestPostAjax();
        $state = $this->metaTagService->toggleVisible($id);

        return [
            'status' => 'ok',
            'value' => $state,
            'message' => 'The requested photo has been switched successfully',
        ];
    }
}
