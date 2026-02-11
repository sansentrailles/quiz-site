<?php

namespace app\modules\seo\forms\backend\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\seo\models\MetaTag as SearchModel;

/**
 * MetaTagSearch represents the model behind the search form seo photo `app\modules\seo\models\MetaTag`.
 */
class MetaTagSearch extends SearchModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_visible'], 'integer'],
            [['name', 'content'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $withContent = false)
    {
        $query = SearchModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['name' => SORT_ASC],
            ]
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
            'is_visible' => $this->is_visible,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }

}
