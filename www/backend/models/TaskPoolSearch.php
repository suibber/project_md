<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TaskPool;

/**
 * TaskPoolSearch represents the model behind the search form about `backend\models\TaskPool`.
 */
class TaskPoolSearch extends TaskPool
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['has_poi', 'status'], 'integer'],
            [['title', 'phonenum', 'contact'], 'safe'],
            [['company_name', 'city', 'origin_id', 'origin', 'created_time'], 'safe'],
            [['lng', 'lat'], 'number'],
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
    public function search($params)
    {
        $query = TaskPool::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder'=>
                ['release_date'=>SORT_DESC]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'lng' => $this->lng,
            'lat' => $this->lat,
            'has_poi' => $this->has_poi,
            'contact' => $this->contact,
            'phonenum' => $this->phonenum,
            'status' => $this->status,
            'created_time' => $this->created_time,
        ]);

        $query->andFilterWhere(['like', 'company_name', $this->company_name])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'origin_id', $this->origin_id])
            ->andFilterWhere(['like', 'origin', $this->origin])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'details', $this->details]);

        return $dataProvider;
    }
}
