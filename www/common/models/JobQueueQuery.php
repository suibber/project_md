<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[JobQueue]].
 *
 * @see JobQueue
 */
class JobQueueQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return JobQueue[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return JobQueue|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
