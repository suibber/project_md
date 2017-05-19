<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AccountEvent;
use common\models\Resume;

/**
 * AccountEventSearch represents the model behind the search form about `common\models\AccountEvent`.
 */
class AccountEventSearch extends AccountEvent
{
    public $user_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'type', 'related_id','locked'], 'integer'],
            [['date', 'created_time', 'note','user_name'], 'safe'],
            [['task_gid'], 'string'],
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
        $query = AccountEvent::find()->with('userinfo')->with('operator');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if ($this->user_name){
            $resumes = Resume::find()->where(
                ['name'=> $this->user_name])->all();
            $_ids   = [];
            foreach( $resumes as $k => $v ){
                $_ids[]   = $v->user_id;
            }
            if (count($_ids)>0){
                $query->andFilterWhere(['in', 'operator_id', $_ids]);
            } else {
                $query->andWhere('1=2');
            }
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'date' => $this->date,
            'user_id' => $this->user_id,
            'value' => $this->value,
            'created_time' => $this->created_time,
            'balance' => $this->balance,
            'type' => $this->type,
            'related_id' => $this->related_id,
            'task_gid' => $this->task_gid,
            'locked'    => $this->locked,
        ]);

        $query->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
