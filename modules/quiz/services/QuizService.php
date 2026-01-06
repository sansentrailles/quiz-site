<?php

declare(strict_types=1);

namespace app\modules\quiz\services;

use app\custom\helpers\StorageFileHelper;
use app\custom\services\base\BaseService;
use app\modules\quiz\models\Quiz as Model;
use app\modules\quiz\models\QuizLabel;
use app\modules\quiz\repositories\QuizRepository as Repository;
use app\custom\services\transaction\TransactionManager;
use app\modules\quiz\repositories\QuizLabelRepository;
use yii\base\Model as Form;

class QuizService extends BaseService
{
    private $quizLabelRepository;

    public function __construct(
        TransactionManager $transactionManager,
        QuizLabelRepository $quizLabelRepository
    ) {
        $this->transactionManager = $transactionManager;
        $this->quizLabelRepository = $quizLabelRepository;

        parent::__construct($this->transactionManager);
    }

    public function create(Form $form)
    {
        $transaction = $this->transactionManager->begin();
        try {
            $model = Model::add($form);
            $this->repository->add($model);
            $this->saveRefs($form, $model);

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        return $model;
    }

    public function edit(Form $form)
    {
        $transaction = $this->transactionManager->begin();
        try {
            $model = $this->repository->find($form->id);
            $model->edit($form);
            $this->repository->save($model);
            $this->saveRefs($form, $model, $update = true);

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        return $model;
    }

    private function saveRefs(Form $form, Model $model, $update = false): void
    {
        if ($update) {
            $this->quizLabelRepository->deleteAllForQuiz($model->id);
        }

        foreach ($form->labels as $labelId) {
            if ((int)$labelId === 0) {
                continue;
            }

            $quizLabel = QuizLabel::createByPrimaryKey($model->id, $labelId);
            $this->quizLabelRepository->add($quizLabel);
        }
    }

    // public function create(Form $form)
    // {
    //     $model = Model::add($form);
    //     $this->repository->add($model);
    //     return $model;
    // }

    // public function edit(Form $form)
    // {
    //     $model = $this->repository->find($form->id);
    //     $model->edit($form);
    //     $this->repository->save($model);

    //     return $model;
    // }

    public function getRepositoryClass()
    {
        return Repository::class;
    }

    public function deleteImage($id): void
    {
        $model = $this->repository->find($id);
        $files = $model->getImageFiles();
        StorageFileHelper::removeFiles($files);
        $model->image = null;
        $this->repository->save($model);
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
