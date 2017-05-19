<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Device]].
 *
 * @see Device
 */
class DeviceQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Device[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Device|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}