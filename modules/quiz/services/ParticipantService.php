<?php

declare(strict_types=1);

namespace app\modules\quiz\services;

use app\custom\services\base\BaseService;
use app\modules\quiz\models\Participant as Model;
use app\modules\quiz\repositories\ParticipantRepository as Repository;
use yii\base\Model as Form;
use app\modules\quiz\forms\backend\ParticipantForm;

class ParticipantService extends BaseService
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

    public function savePoints(array $pointLists, array $places)
    {
        foreach ($pointLists as $id => $points) {
            try {
                $model = $this->find((int)$id);
            } catch (\Exception $e) {
                continue;
            }

            $form = new ParticipantForm($model);
            $form->points = $points;

            if (isset($places[$id])) {
                $form->place = $places[$id];
            }

            $this->save($form);
        }
    }

    public function setPlacesByQuiz(int $quizId)
    {
        $participants = $this->repository->getParticipantsByQuiz($quizId);
        foreach ($participants as $k => $participant) {
            $place = $k + 1;
            $form = new ParticipantForm($participant);
            $form->place = $place;

            $this->save($form);
        }
    }

    public function getStats(int $quizId)
    {
        return $this->repository->getStats($quizId);
    }

    public function getRating()
    {
        return $this->repository->getRating();
    }

    public function getTotalPoints()
    {
        return $this->repository->getTotalPoints();
    }
}
