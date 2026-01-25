<?php

declare(strict_types=1);

namespace app\modules\quiz\repositories;

use app\custom\services\base\BaseRepository;
use app\modules\quiz\models\Team as Model;
use app\modules\quiz\models\Participant;
use yii\db\Query;

class TeamRepository extends BaseRepository
{
    public function getModelClass(): void
    {
        $this->model = Model::class;
    }

    public function getRating()
    {
        // Шаг 1: Получаем агрегированные данные по командам
        $teamsData = (new Query())
            ->select([
                'team.id',
                'team.title',
                'played_quizes' => 'COUNT(p.quiz_id)',
                'total_points' => 'SUM(p.points)',
                'avg_points' => 'AVG(p.points)',
            ])
            ->from(['team' => Model::tableName()])
            ->leftJoin(['p' => Participant::tableName()], 'p.team_id = team.id')
            ->groupBy(['team.id', 'team.title'])
            ->having(['>', 'played_quizes', 0])
            ->orderBy(['total_points' => SORT_DESC, 'avg_points' => SORT_DESC, 'team.id' => SORT_ASC])
            ->all();

        // Назначаем текущие места
        foreach ($teamsData as $index => &$row) {
            $row['current_place'] = $index + 1;
        }

        // Шаг 2: Для каждой команды получаем её последнее место (из последнего квиза)
        $teamIds = array_column($teamsData, 'id');
        $lastPlaces = (new Query())
            ->select(['p.team_id', 'p.place'])
            ->from(['p' => Participant::tableName()])
            ->innerJoin(['q' => 'quizes'], 'p.quiz_id = q.id')
            ->where(['p.team_id' => $teamIds])
            ->orderBy(['q.id' => SORT_DESC]) // предполагаем, что id квиза растёт со временем
            ->indexBy('team_id')
            ->column(); // вернёт [team_id => place]

        // Шаг 3: Добавляем тренд
        foreach ($teamsData as &$row) {
            $lastPlace = $lastPlaces[$row['id']] ?? null;
            $currentPlace = $row['current_place'];

            if ($lastPlace === null) {
                $row['trend'] = '—'; // нет данных
            } elseif ($currentPlace < $lastPlace) {
                $row['trend'] = 'up'; // поднялась (место стало меньше числом)
            } elseif ($currentPlace > $lastPlace) {
                $row['trend'] = 'down'; // опустилась
            } else {
                $row['trend'] = 'same';
            }
        }

        return $teamsData;
    }

    public function getByName(string $name)
    {
        $searchTerm = '%'.trim($name).'%';
        $query = $this->model::find()
            ->where(['like', 'title', $searchTerm, false]);

        return $query->one();
    }

    public function getAvailableTeams(int $quizId)
    {
        $query = $this->model::find()
        ->innerJoinWith('participants') // Предполагается наличие связи quizParticipants
        ->where([
            'quiz_participants.quiz_id' => $quizId,
            'quiz_participants.is_opened' => 1,
        ])
        ->andWhere(['<', 'quiz_participants.persons', 10]);
        
        return $query->all();
    }
}
