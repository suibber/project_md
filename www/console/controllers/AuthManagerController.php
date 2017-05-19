<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

class AuthManagerController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        /***
        // add "createPost" permission
        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Create a post';
        $auth->add($createPost);

        // add "updatePost" permission
        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = 'Update post';
        $auth->add($updatePost);

         */

        $worker = $auth->createRole('worker');
        $auth->add($worker);

        $hunter = $auth->createRole('hunter');
        $auth->add($hunter);

        $product_manager = $auth->createRole('product_manager');
        $auth->add($product_manager);

        $saleman = $auth->createRole('saleman');
        $auth->add($saleman);

        $supervisor = $auth->createRole('supervisor');
        $auth->add($supervisor);

        //$auth->addChild($author, $createPost);

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        //$auth->addChild($admin, $updatePost);
        $auth->addChild($admin, $hunter);
        $auth->addChild($admin, $product_manager);
        $auth->addChild($admin, $saleman);

        echo "DONE!";
    }
}
