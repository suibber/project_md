<?php

namespace common\models;
use \DateTime;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TaskApplicant;
use common\models\Task;

/**
 * TaskApplicantSearch represents the model behind the search form about `common\models\TaskApplicant`.
 */
class TaskApplicantSearch extends TaskApplicant
{
    public $task_title;
    public $resume_phonenum;
    public $resume_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'task_id', 'status'], 'integer'],
            [['created_time', 'task_title'], 'safe'],
            [['company_alerted', 'applicant_alerted'], 'boolean'],
            [['resume_phonenum', 'resume_name'], 'safe'],
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
        $query = TaskApplicant::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder'=>['id'=>SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if ($this->created_time){
            list($from_date, $to_date) = explode(' - ', $this->created_time);
            if($from_date){
                $query->andWhere(['>=', 'created_time', $from_date]);
                $query->andWhere(['<=', 'created_time', $to_date]);
            }

            Yii::$app->session->set('taskapp_created_from_date', $from_date);
            Yii::$app->session->set('taskapp_created_to_date', $to_date);
        }

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
        if ($this->resume_name){
            $resumes = Resume::find()->where(
                ['name'=> $this->resume_name])->all();
            $_ids   = [];
            foreach( $resumes as $k => $v ){
                $_ids[]   = $v->user_id;
            }
            if (count($_ids)>0){
                $query->andFilterWhere(['in', 'user_id', $_ids]);
            } else {
                $query->andWhere('1=2');
            }
        }
        if ($this->resume_phonenum){
            $resumes = Resume::find()->where(
                ['phonenum'=>$this->resume_phonenum])->all();
            $_ids   = [];
            foreach( $resumes as $k => $v ){
                $_ids[]   = $v->user_id;
            }
            if (count($_ids)>0){
                $query->andFilterWhere(['in', 'user_id', $_ids]);
            } else {
                $query->andWhere('1=2');
            }
        }
 
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'status' => $this->status,
            'company_alerted'=> $this->company_alerted,
            'applicant_alerted' => $this->applicant_alerted,
            'task_id' => $this->task_id,
        ]);

        return $dataProvider;
    }
}
