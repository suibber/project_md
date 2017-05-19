<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[SysMessage]].
 *
 * @see SysMessage
 */
class SysMessageQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SysMessage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SysMessage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}