<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Company;

/**
 * CompanySearch represents the model behind the search form about `common\models\Company`.
 */
class CompanySearch extends Company
{
    public $user_id_exisit;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'examined_by', 'user_id' ,'user_id_exisit'], 'integer'],
            [['contact_name', 'contact_phone', 
            'contact_email', 'name', 'examined_time'], 'safe'],
            [['exam_status', 'exam_result', 'origin'], 'integer'],
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
        $query = Company::find();

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

        $query->andFilterWhere([
            'id' => $this->id,
            'examined_time' => $this->examined_time,
            'status' => $this->status,
            'examined_by' => $this->examined_by,
            'contact_phone' => $this->contact_phone,
            'contact_name' => $this->contact_name,
            'contact_email' => $this->contact_email,
            'exam_status' => $this->exam_status,
            'user_id' => $this->user_id,
            'origin' => $this->origin,
        ]);

        // 'exam_result & ' . $this->exam_result => true, // 未测试 

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
