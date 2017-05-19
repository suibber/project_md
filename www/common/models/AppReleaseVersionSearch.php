<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AppReleaseVersion;

/**
 * AppReleaseVersionSearch represents the model behind the search form about `common\models\AppReleaseVersion`.
 */
class AppReleaseVersionSearch extends AppReleaseVersion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'device_type'], 'integer'],
            [['app_version', 'html_version', 'update_url', 'release_time', 'h5_map_file'], 'safe'],
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
        $query = AppReleaseVersion::find();

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
            'device_type' => $this->device_type,
            'release_time' => $this->release_time,
        ]);

        $query->andFilterWhere(['like', 'app_version', $this->app_version])
            ->andFilterWhere(['like', 'html_version', $this->html_version])
            ->andFilterWhere(['like', 'update_url', $this->update_url])
            ->andFilterWhere(['like', 'h5_map_file', $this->h5_map_file]);

        return $dataProvider;
    }
}
