<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\WeichatErweimaLog;
use common\models\User;

/**
 * WeichatErweimaLogSearch represents the model behind the search form about `common\models\WeichatErweimaLog`.
 */
class WeichatErweimaLogSearch extends WeichatErweimaLog
{
    public $username;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'erweima_id', 'has_bind', 'follow_by_scan'], 'integer'],
            [['openid', 'create_time','username'], 'safe'],
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
    public function search($params,$erweima_id=0)
    {
        $query = WeichatErweimaLog::find();

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
            'erweima_id' => $this->erweima_id,
            'has_bind' => $this->has_bind,
            'follow_by_scan' => $this->follow_by_scan,
        ]);

        $query->andFilterWhere(['like', 'create_time', $this->create_time]);

        if( $erweima_id ){
            $query->andFilterWhere(['erweima_id'=> $erweima_id]);
        }

        if ($this->username){
                $user = User::find()->with('weichat')->where(
                    ['username'=> $this->username])->one();
                if (count($user)>0){
                    $query->andFilterWhere(['openid'=> $user->weichat->openid]);
                }         
        }

        $query->andFilterWhere(['like', 'openid', $this->openid]);

        return $dataProvider;
    }
}
