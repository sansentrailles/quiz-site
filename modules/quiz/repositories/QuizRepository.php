<?php

declare(strict_types=1);

namespace app\modules\quiz\repositories;

use app\custom\services\base\BaseRepository;
use app\modules\quiz\models\Quiz as Model;

class QuizRepository extends BaseRepository
{
    public function getModelClass(): void
    {
        $this->model = Model::class;
    }

    public function getVisible()
    {
        return $this->model::find()
            ->andWhere(['is_visible' => Model::STATUS_VISIBLE])
            ->orderBy(['date' => SORT_ASC])
            ->all();
    }

    public function getByUrl(string $url)
    {
        return $this->model::findOne(['url' => $url]);
    }
}
