<?php

namespace app\modules\seo\repositories;

use app\modules\seo\models\Metric as Model;
use app\custom\services\base\BaseRepository;

class MetricRepository extends BaseRepository
{
    public function getModelClass()
    {
        $this->model = Model::class;
    }

    public function getVisible()
    {
        return $this->model::find()
            ->andWhere(['is_visible' => Model::STATUS_VISIBLE])
            ->orderBy(['ord' => SORT_ASC])
            ->all();
    }

    public function getVisibleForPlace(int $place)
    {
        return $this->model::find()
            ->andWhere([
                'is_visible' => Model::STATUS_VISIBLE,
                'place' => $place,
            ])
            ->orderBy(['ord' => SORT_ASC])
            ->all();
    }
}
