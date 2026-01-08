<?php

declare(strict_types=1);

namespace app\modules\quiz\repositories;

use app\custom\services\base\BaseRepository;
use app\modules\quiz\models\Team as Model;

class TeamRepository extends BaseRepository
{
    public function getModelClass(): void
    {
        $this->model = Model::class;
    }
}
