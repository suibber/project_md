<?php
namespace api\extensions;

use Yii;
use yii\base\Exception;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use common\models\User;

/**
 * Base extension Module
 * 
 * @author Dawei
 * @since 1.0
 */
class BaseModule extends \yii\base\Module
{

    public $publicActions = [
        // 'controller' => actions
        //'entry' => ['*'],
        //'task-address' => ['nearby'],
    ];

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        if (!$this->isActionPublic()){
            // 留出auth controller 登录
            $behaviors['authenticator'] = [
                'class' => CompositeAuth::className(),
                'authMethods' => [
                // QueryParamAuth 
                    ['class' => QueryParamAuth::className(), 'tokenParam' => 'access_token'],
                    ['class' => HttpBasicAuth::className(), 'auth' => [$this, 'authByPassword']],
                ],
            ];
        }
        return $behaviors;
    }

    public function isActionPublic()
    {
        $controller = Yii::$app->controller->id;
        $action = Yii::$app->controller->action->id;
        if (isset($this->publicActions[$controller])){
            $record = $this->publicActions[$controller];
            if (in_array('*', $record) || in_array($action, $record)){
                return true;
            }
        }
        return false;
    }

    /**
     * Finds user by username and password
     *
     * @param string $username
     * @param string $password
     * @return static|null
     */
    public function authByPassword($username, $password) {
        if(empty($username) || empty($password))
            return null;

        $user = User::findOne([
            'username' => $username,
        ]);

        if(empty($user))
            return null;

        // if password validation fails
        if(!$user->validatePassword($password))
            return null;

        return $user;
    }
}
