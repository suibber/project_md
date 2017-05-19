<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[TaskPoolWhiteList]].
 *
 * @see TaskPoolWhiteList
 */
class TaskPoolWhiteListQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return TaskPoolWhiteList[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TaskPoolWhiteList|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}