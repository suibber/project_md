<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Resume;

/**
 * ResumeSearch represents the model behind the search form about `common\models\Resume`.
 */
class ResumeSearch extends Resume
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'gender', 'height', 'is_student', 'grade', 'status', 'user_id', 'home', 'workplace','exam_status'], 'integer'],
            [['name', 'phonenum', 'birthdate', 'degree', 'nation', 'college', 'avatar', 'gov_id', 'created_time', 'updated_time'], 'safe'],
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
        $query = Resume::find();

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
            'gender' => $this->gender,
            'birthdate' => $this->birthdate,
            'height' => $this->height,
            'is_student' => $this->is_student,
            'grade' => $this->grade,
            'created_time' => $this->created_time,
            'updated_time' => $this->updated_time,
            'status' => $this->status,
            'user_id' => $this->user_id,
            'home' => $this->home,
            'workplace' => $this->workplace,
            'exam_status' => $this->exam_status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'phonenum', $this->phonenum])
            ->andFilterWhere(['like', 'degree', $this->degree])
            ->andFilterWhere(['like', 'nation', $this->nation])
            ->andFilterWhere(['like', 'college', $this->college])
            ->andFilterWhere(['like', 'avatar', $this->avatar])
            ->andFilterWhere(['like', 'gov_id', $this->gov_id]);

        return $dataProvider;
    }
}
