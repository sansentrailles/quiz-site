<?php

declare(strict_types=1);

namespace app\modules\quiz\services;

use app\custom\services\base\BaseService;
use app\modules\quiz\forms\backend\TeamForm;
use app\modules\quiz\models\Team as Model;
use app\modules\quiz\repositories\TeamRepository as Repository;
use yii\base\Model as Form;

class TeamService extends BaseService
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

    public function getRating()
    {
        return $this->repository->getRating();
    }

    public function getByName(string $name)
    {
        return $this->repository->getByName($name);
    }

    public function getAvailableTeams(int $quizId)
    {
        return $this->repository->getAvailableTeams($quizId);
    }

    public function createByName(string $title, ?string $name = null, ?string $contact = null)
    {
        $form = new TeamForm();
        $form->title = $title;

        return $this->save($form);
    }
}
