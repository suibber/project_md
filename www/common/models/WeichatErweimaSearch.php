<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\WeichatErweima;

/**
 * WeichatErweimaSearch represents the model behind the search form about `common\models\WeichatErweima`.
 */
class WeichatErweimaSearch extends WeichatErweima
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'scene_id'], 'integer'],
            [['title', 'comment', 'create_time', 'update_time', 'ticket', 'after_msg'], 'safe'],
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
        $query = WeichatErweima::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'type' => $this->type,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'scene_id' => $this->scene_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'ticket', $this->ticket])
            ->andFilterWhere(['like', 'after_msg', $this->after_msg]);

        return $dataProvider;
    }
}
