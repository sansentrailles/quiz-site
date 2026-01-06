<?php

declare(strict_types=1);

namespace app\modules\quiz\repositories;

use app\custom\services\base\BaseRepository;
use app\modules\quiz\models\Label as Model;

class LabelRepository extends BaseRepository
{
    public function getModelClass(): void
    {
        $this->model = Model::class;
    }
}
