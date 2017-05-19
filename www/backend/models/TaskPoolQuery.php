<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[TaskPool]].
 *
 * @see TaskPool
 */
class TaskPoolQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return TaskPool[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TaskPool|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}