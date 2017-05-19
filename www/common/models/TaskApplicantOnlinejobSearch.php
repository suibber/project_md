<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TaskApplicantOnlinejob;
use common\models\Task;

/**
 * TaskApplicantOnlinejobSearch represents the model behind the search form about `common\models\TaskApplicantOnlinejob`.
 */
class TaskApplicantOnlinejobSearch extends TaskApplicantOnlinejob
{
    public $task_title;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'app_id', 'user_id', 'task_id', 'has_sync_wechat_pic'], 'integer'],
            [['reason', 'needinfo', 'need_phonenum', 'need_username', 'need_person_idcard', 'created_time', 'updated_time', 'task_title'], 'safe'],
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
        $query = TaskApplicantOnlinejob::find();

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
            'status' => $this->status,
            'app_id' => $this->app_id,
            'user_id' => $this->user_id,
            'task_id' => $this->task_id,
            'has_sync_wechat_pic' => $this->has_sync_wechat_pic,
            'created_time' => $this->created_time,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'reason', $this->reason])
            ->andFilterWhere(['like', 'needinfo', $this->needinfo])
            ->andFilterWhere(['like', 'need_phonenum', $this->need_phonenum])
            ->andFilterWhere(['like', 'need_username', $this->need_username])
            ->andFilterWhere(['like', 'need_person_idcard', $this->need_person_idcard]);

        // 根据标题搜索
        if( isset($this->task_title) && $this->task_title ){
            $task_m = Task::find()->where("`title` LIKE '%".$this->task_title."%'")->asArray()->all();
            $_ids   = array();
            foreach( $task_m as $k => $v ){
                $_ids[]   = $v['id'];
            }
            if (count($_ids)>0){
                $query->andFilterWhere(['in', 'task_id', $_ids]);
            } else {
                $query->andWhere('1=2');
            }
        }
        
        return $dataProvider;
    }
}
