<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\WithdrawCash;

/**
 * WithdrawCashSearch represents the model behind the search form about `common\models\WithdrawCash`.
 */
class WithdrawCashSearch extends WithdrawCash
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'type', 'payout_id', 'status'], 'integer'],
            [['value'], 'number'],
            [['withdraw_time', 'updated_time', 'note'], 'safe'],
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
        $query = WithdrawCash::find()
            ->joinWith('payout')
            ->joinWith('userinfo')
            ->joinWith('operatorinfo');

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
            '`jz_withdraw_cash`.id' => $this->id,
            '`jz_withdraw_cash`.user_id' => $this->user_id,
            '`jz_withdraw_cash`.value' => $this->value,
            '`jz_withdraw_cash`.withdraw_time' => $this->withdraw_time,
            '`jz_withdraw_cash`.type' => $this->type,
            '`jz_withdraw_cash`.payout_id' => $this->payout_id,
            '`jz_withdraw_cash`.`status`' => $this->status,
            '`jz_withdraw_cash`.updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
