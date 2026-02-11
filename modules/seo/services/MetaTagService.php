<?php

namespace app\modules\seo\services;

use yii\helpers\Url;
use app\modules\seo\repositories\MetaTagRepository as Repository;
use app\modules\seo\models\MetaTag as Model;
use yii\base\Model as Form;
use app\custom\services\base\BaseService;

class MetaTagService extends BaseService
{
    public function create(Form $form)
    {
        $model = Model::add($form);
        $this->repository->add($model);
        return $model;
    }

    public function edit(Form $form)
    {
        $model = $this->repository->find($form->id);
        $model->edit($form);
        $this->repository->save($model);

        return $model;
    }

    public function toggleVisible($id)
    {
        $model = $this->repository->find($id);
        $state = $model->toggleVisible();
        $this->repository->save($model);

        return $state;
    }

    public function getRepositoryClass()
    {
        return Repository::class;
    }

    public function getVisible()
    {
        return $this->repository->getVisible();
    }
}
