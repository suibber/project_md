<?php
/**
 */

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\console\Exception;
use \common\models\User;

/**
 */

class UserController extends Controller
{
    /**
     * @var string controller default action ID.
     */
    public $defaultAction = 'list';


    public function actionList(){
    }


    public function actionAdd($phonenum, $password){
        $user = new User();
        $user->username = $phonenum;
        $user->setPassword($password);
        if ($user->validate()) {
            $user->save();
            echo "$phonenum 创建完毕\n";
        }
        else {
            foreach($user->getErrors() as $key=>$errors){
                echo join('\n', $errors) . "\n";
            }
        }
    }

    public function actionSetRole($phonenum, $role_name)
    {
        $user = User::findOne(['username'=>$phonenum]);
        if ($user){
            $auth = Yii::$app->authManager;
            $role = $auth->getRole($role_name);
            if ($role){
                if (!$auth->checkAccess($user->getId(), $role_name)) {
                    $auth->assign($role, $user->getId());
                    echo "$phonenum 权限设置完毕\n";
                } else {
                    echo "该用户已有权限.\n";
                }
            } else {
                echo "未知的角色\n";
            }

        } else {
            echo "$phonenum 用户不存在\n";
        }
    }

    public function actionChangePassword($phonenum, $password)
    {
        $user = User::findOne(['username'=>$phonenum]);
        if (!$user){
            echo "No User found!\n";
        } else {
            $user->setPassword($password);
            $user->save();
            echo "Change done!\n";
        }

    }
}

