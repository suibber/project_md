<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\JobQueue;

/**
 * JobQueueSearch represents the model behind the search form about `common\models\JobQueue`.
 */
class JobQueueSearch extends JobQueue
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'retry_times', 'priority', 'status'], 'integer'],
            [['task_name', 'params', 'start_time', 'message'], 'safe'],
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
        $query = JobQueue::find();

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
            'retry_times' => $this->retry_times,
            'start_time' => $this->start_time,
            'priority' => $this->priority,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'task_name', $this->task_name])
            ->andFilterWhere(['like', 'params', $this->params])
            ->andFilterWhere(['like', 'message', $this->message]);

        return $dataProvider;
    }
}
