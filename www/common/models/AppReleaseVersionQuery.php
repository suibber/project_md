<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[AppReleaseVersion]].
 *
 * @see AppReleaseVersion
 */
class AppReleaseVersionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return AppReleaseVersion[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AppReleaseVersion|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
