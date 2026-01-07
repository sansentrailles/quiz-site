<?php

declare(strict_types=1);

namespace app\modules\quiz\controllers\backend;

use app\modules\quiz\controllers\common\Controller;
use app\modules\quiz\forms\backend\FaqItemForm as Form;
use app\modules\quiz\forms\backend\search\FaqItemSearch as SearchModel;
use app\modules\quiz\Module;
use Yii;
use yii\filters\VerbFilter;

class FaqItemsController extends Controller
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
            $this->faqItemService->save($model);

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $post = Yii::$app->request->post();
        $entity = $this->faqItemService->find((int)$id);
        $model = new Form($entity);

        if ($model->load($post) && $model->validate()) {
            $this->faqItemService->save($model);

            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->faqItemService->findOrFail((int)$id);
        $this->faqItemService->delete($id);

        return $this->redirect(['index']);
    }

    public function actionToggleVisible($id)
    {
        $this->guardRequestPostAjax();
        $state = $this->faqItemService->toggleVisible($id);

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

        $this->faqItemService->changeOrder($ords);
        Yii::$app->getSession()->setFlash('success', Module::t('common', 'ORD_SAVED_SUCCESS'));
        return $this->redirect($request->referrer);
    }
}
