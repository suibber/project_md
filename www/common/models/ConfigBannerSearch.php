<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ConfigBanner;

/**
 * ConfigBannerSearch represents the model behind the search form about `common\models\ConfigBanner`.
 */
class ConfigBannerSearch extends ConfigBanner
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'city_id', 'type', 'display_order'], 'integer'],
            [['title', 'pic', 'url', 'offline_date', 'created_time'], 'safe'],
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
        $query = ConfigBanner::find();

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
            'city_id' => $this->city_id,
            'type' => $this->type,
            'display_order' => $this->display_order,
            'offline_date' => $this->offline_date,
            'created_time' => $this->created_time,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'pic', $this->pic])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}
