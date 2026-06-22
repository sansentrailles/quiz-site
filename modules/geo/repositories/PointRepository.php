<?php

declare(strict_types=1);

namespace app\modules\geo\repositories;

use app\custom\services\base\BaseRepository;
use app\modules\geo\models\Point as Model;

class PointRepository extends BaseRepository
{
    public function getModelClass(): void
    {
        $this->model = Model::class;
    }
}
