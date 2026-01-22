<?php

declare(strict_types=1);

namespace app\modules\quiz\services;

use app\custom\services\base\BaseService;
use app\modules\quiz\models\QuizBooking as Model;
use app\modules\quiz\repositories\QuizBookingRepository as Repository;
use yii\base\Model as Form;
use app\modules\quiz\forms\backend\QuizBookingForm as BackendBookingForm;
use app\modules\quiz\forms\frontend\QuizBookingForm as FrontendBookingForm;

class QuizBookingService extends BaseService
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

    public function booking(FrontendBookingForm $frontendForm)
    {
        $form = $this->prepareBookingForm($frontendForm);
        return $this->save($form);
    }

    private function prepareBookingForm(FrontendBookingForm $frontendForm): BackendBookingForm
    {
        $form = new BackendBookingForm();

        $form->quiz_id = $frontendForm->quizId;
        $form->name = $frontendForm->name;
        $form->team_name = $frontendForm->teamName;
        $form->holiday = $frontendForm->holiday;
        $form->persons = $frontendForm->persons;
        $form->contact = $frontendForm->contact;
        $form->is_single = $frontendForm->isSingle;
        $form->is_opened = $frontendForm->isOpened;

        return $form;
    }
}
