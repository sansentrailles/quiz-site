<?php

declare(strict_types=1);

namespace app\modules\quiz\forms\backend\search;

use app\modules\quiz\models\QuizBooking as SearchModel;
use yii\base\Model;
use yii\data\ActiveDataProvider;


class QuizBookingSearch extends SearchModel
{
    public function rules()
    {
        return [
            [['id', 'quiz_id', 'persons', 'created_at'], 'integer'],
            [['team_name', 'name'], 'string'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied.
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = SearchModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'quiz_id' => $this->quiz_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }

    public function forQuiz($quizId)
    {
        $this->quiz_id = $quizId;
        return $this;
    }
}
