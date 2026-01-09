<?php

declare(strict_types=1);

namespace app\modules\quiz\repositories;

use app\custom\services\base\BaseRepository;
use app\modules\quiz\models\Participant as Model;

class ParticipantRepository extends BaseRepository
{
    public function getModelClass(): void
    {
        $this->model = Model::class;
    }

    public function getParticipantsByQuiz(int $quizId)
    {
        return $this->model::find()
            ->andWhere(['quiz_id' => (int) $quizId])
            ->orderBy(['points' => SORT_DESC])
            ->all();
    }

    public function getStats(int $quizId)
    {
        return $this->model::find()
            ->select([
                'MAX(points) as max_points',
                'MIN(points) as min_points',
                'SUM(persons) as total_persons',
                'COUNT(*) as teams_count'
            ])
            ->where(['quiz_id' => $quizId])
            ->asArray()
            ->one();
    }
}
