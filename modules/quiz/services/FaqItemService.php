<?php

declare(strict_types=1);

namespace app\modules\quiz\services;

use app\custom\services\base\BaseService;
use app\modules\quiz\models\FaqItem as Model;
use app\modules\quiz\repositories\FaqItemRepository as Repository;
use yii\base\Model as Form;

class FaqItemService extends BaseService
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

    public function getRepositoryClass()
    {
        return Repository::class;
    }

    public function toggleVisible($id)
    {
        $model = $this->repository->find($id);
        $state = $model->toggleVisible();
        $this->repository->save($model);

        return $state;
    }

    public function getVisible()
    {
        return $this->repository->getVisible();
    }
}
