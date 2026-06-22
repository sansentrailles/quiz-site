<?php

declare(strict_types=1);

namespace app\modules\geo\repositories;

use app\custom\services\base\BaseRepository;
use app\modules\geo\models\Route as Model;

class RouteRepository extends BaseRepository
{
    public function getModelClass(): void
    {
        $this->model = Model::class;
    }
}
