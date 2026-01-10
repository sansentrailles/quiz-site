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

    public function getActualQuizes()
    {
        $currentTime = time(); // Текущая дата в формате timestamp
        return $this->model::find()
            ->where(['is_visible' => true])
            ->andWhere(['>', 'date', $currentTime])
            ->orderBy(['date' => SORT_ASC])
            ->all();
    }

    public function getExpiredQuizes()
    {
        $currentTime = time();
        return $this->model::find()
            ->where(['is_visible' => true])
            ->andWhere(['<', 'date', $currentTime])
            ->orderBy(['date' => SORT_DESC]) // Сортируем от более новых к более старым
            ->all();
    }

    public function getCurrentMonthQuizCount()
    {
        return $this->model::find()
            ->andWhere(['>=', 'date', strtotime('first day of this month 00:00:00')])
            ->andWhere(['<=', 'date', strtotime('last day of this month 23:59:59')])
            ->count();
    }
}
