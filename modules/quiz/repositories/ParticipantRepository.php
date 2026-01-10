<?php

declare(strict_types=1);

namespace app\modules\quiz\repositories;

use app\custom\services\base\BaseRepository;
use app\modules\quiz\models\Participant as Model;
use app\modules\quiz\models\Quiz;

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

    public function getRating()
    {
        // 1. Находим ID последнего квиза (используя для расчета динамики)
        $lastQuizId = Quiz::find()->max('id');

        // 2. Получаем текущий общий рейтинг (агрегация данных)
        // Используем joinWith, чтобы получить название команды
        $currentStats = $this->model::find()
            ->select([
                'team_id',
                'COUNT(*) as games_played',
                'SUM(points) as total_points',
                'AVG(points) as avg_points'
            ])
            ->joinWith('team') // Предполагается, что в модели Participant есть связь getTeam()
            ->groupBy('team_id')
            ->orderBy(['total_points' => SORT_DESC, 'avg_points' => SORT_DESC]) // Сортировка по очкам
            ->asArray() // Получаем как массив для быстрой обработки
            ->all();

        // 3. Получаем рейтинг БЕЗ последнего квиза (для расчета тренда)
         // 3. Получаем рейтинг БЕЗ последнего квиза (для расчета тренда)
        $previousStats = [];
        if ($lastQuizId) {
            $previousStatsRaw = $this->model::find()
                ->select([
                    'team_id', 
                    'SUM(points) as total_points',
                    'AVG(points) as avg_points' // <--- Добавьте эту строку, чтобы поле было доступно для сортировки
                ])
                ->where(['<>', 'quiz_id', $lastQuizId])
                ->groupBy('team_id')
                // Сортировка должна соответствовать основной логике: сначала сумма, потом среднее
                ->orderBy(['total_points' => SORT_DESC, 'avg_points' => SORT_DESC])
                ->asArray()
                ->all();
            
            // Создаем ассоциативный массив: [team_id => место]
            foreach ($previousStatsRaw as $index => $stat) {
                $previousStats[$stat['team_id']] = $index + 1;
            }
        }

        // 4. Формируем финальный массив данных для таблицы
        $data = [];
        foreach ($currentStats as $index => $stat) {
            $teamId = $stat['team_id'];
            $currentPlace = $index + 1;
            
            // Определяем предыдущее место. Если команды не было в прошлом списке - значит она новая.
            $oldPlace = isset($previousStats[$teamId]) ? $previousStats[$teamId] : null;

            // Логика тренда
            $trend = 'same'; // 0 - без изменений
            if ($oldPlace === null) {
                $trend = 'new'; // Новая команда
            } elseif ($currentPlace < $oldPlace) {
                $trend = 'up'; // Поднялась (например, было 5, стало 2)
            } elseif ($currentPlace > $oldPlace) {
                $trend = 'down'; // Опустилась (например, было 2, стало 5)
            }

            $data[] = [
                'place' => $currentPlace,
                'title' => $stat['team']['title'] ?? 'Команда удалена', // Название из связи
                'games_played' => $stat['games_played'],
                'total_points' => $stat['total_points'],
                'avg_points' => $stat['avg_points'],
                // 'avg_points' => round($stat['avg_points'], 2),
                'trend' => $trend,
                'old_place' => $oldPlace,
            ];
        }

        return $data;
    }
}
