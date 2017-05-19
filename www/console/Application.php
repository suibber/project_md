<?php

namespace console;

use common\models\User;


class Application extends \yii\console\Application
{
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        $identify = User::findByUserName('10000000000');
        $this->user->setIdentity($identify);
        return true;
    }

    public function getUser()
    {
        return $this->get('user');
    }

    public function coreComponents()
    {
        return array_merge(parent::coreComponents(), [
            'user' => ['class' => 'yii\web\User'],
        ]);
    }
}
