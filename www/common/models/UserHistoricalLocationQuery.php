<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[UserHistoricalLocation]].
 *
 * @see UserHistoricalLocation
 */
class UserHistoricalLocationQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return UserHistoricalLocation[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return UserHistoricalLocation|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}