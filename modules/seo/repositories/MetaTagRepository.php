<?php

namespace app\modules\seo\repositories;

use app\modules\seo\models\MetaTag as Model;
use app\custom\services\base\BaseRepository;

class MetaTagRepository extends BaseRepository
{
    public function getModelClass()
    {
        $this->model = Model::class;
    }

    public function getVisible()
    {
        return $this->model::find()
            ->andWhere(['is_visible' => Model::STATUS_VISIBLE])
            ->orderBy(['name' => SORT_ASC])
            ->all();
    }
}
