<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Freetime]].
 *
 * @see Freetime
 */
class FreetimeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Freetime[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Freetime|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}