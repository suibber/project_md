<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UserAccount;

/**
 * UserAccountSearch represents the model behind the search form about `common\models\UserAccount`.
 */
class UserAccountSearch extends UserAccount
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'defalut_withdraw_type'], 'integer'],
            [['money_all', 'money_balance', 'money_success', 'money_doing'], 'number'],
            [['updated_time'], 'safe'],
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
        $query = UserAccount::find()->with('userinfo');

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
            'user_id' => $this->user_id,
            'defalut_withdraw_type' => $this->defalut_withdraw_type,
            'money_all' => $this->money_all,
            'money_balance' => $this->money_balance,
            'money_success' => $this->money_success,
            'money_doing' => $this->money_doing,
            'updated_time' => $this->updated_time,
        ]);

        return $dataProvider;
    }
}
