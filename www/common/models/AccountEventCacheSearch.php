<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AccountEventCache;

/**
 * AccountEventCacheSearch represents the model behind the search form about `common\models\AccountEventCache`.
 */
class AccountEventCacheSearch extends AccountEventCache
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'operator_id', 'type', 'locked'], 'integer'],
            [['date', 'created_time', 'note', 'related_id', 'task_gid'], 'safe'],
            [['value', 'balance'], 'number'],
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
        $query = AccountEventCache::find()
            ->with('operator');

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
            'date' => $this->date,
            'user_id' => $this->user_id,
            'value' => $this->value,
            'operator_id' => $this->operator_id,
            'created_time' => $this->created_time,
            'balance' => $this->balance,
            'type' => $this->type,
            'locked' => $this->locked,
        ]);

        $query->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'related_id', $this->related_id])
            ->andFilterWhere(['like', 'task_gid', $this->task_gid]);

        return $dataProvider;
    }
}
