<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\WeichatUserInfo;

/**
 * WeichatUserInfoSearch represents the model behind the search form about `common\models\WeichatUserInfo`.
 */
class WeichatUserInfoSearch extends WeichatUserInfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userid', 'status', 'is_receive_nearby_msg', 'origin_type'], 'integer'],
            [['openid', 'created_time', 'updated_time', 'weichat_name', 'weichat_head_pic', 'origin_detail', 'erweima_ticket', 'erweima_date'], 'safe'],
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
        $query = WeichatUserInfo::find();

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
            'userid' => $this->userid,
            'status' => $this->status,
            'created_time' => $this->created_time,
            'updated_time' => $this->updated_time,
            'is_receive_nearby_msg' => $this->is_receive_nearby_msg,
            'origin_type' => $this->origin_type,
            'erweima_date' => $this->erweima_date,
        ]);

        $query->andFilterWhere(['like', 'openid', $this->openid])
            ->andFilterWhere(['like', 'weichat_name', $this->weichat_name])
            ->andFilterWhere(['like', 'weichat_head_pic', $this->weichat_head_pic])
            ->andFilterWhere(['like', 'origin_detail', $this->origin_detail])
            ->andFilterWhere(['like', 'erweima_ticket', $this->erweima_ticket]);

        return $dataProvider;
    }
}
