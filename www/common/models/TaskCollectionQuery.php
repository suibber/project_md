<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[TaskCollection]].
 *
 * @see TaskCollection
 */
class TaskCollectionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return TaskCollection[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TaskCollection|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
