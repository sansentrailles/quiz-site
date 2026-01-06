<?php

declare(strict_types=1);

namespace app\modules\quiz\repositories;

use app\custom\services\base\BaseRepository;
use app\modules\quiz\models\QuizLabel as Model;

class QuizLabelRepository extends BaseRepository
{
    public function getModelClass(): void
    {
        $this->model = Model::class;
    }

    public function deleteAllForQuiz($labelId)
    {
        return Model::deleteAll(['label_id' => $labelId]);
    }
}
