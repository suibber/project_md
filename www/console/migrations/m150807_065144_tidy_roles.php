<?php

use yii\db\Schema;
use yii\db\Migration;

class m150807_065144_tidy_roles extends Migration
{
    public function up()
    {
        $authM = Yii::$app->authManager;
        $admin = $authM->getRole("admin");
        if (!$admin){
            echo "Error : no admin found ! \n ";
            exit(1);
        }

        $roles = ["hunter", "product_manager", "saleman", "supervisor", "worker"];
        foreach($roles as $role_name){
            $role = $authM->getRole($role_name);
            if ($role){
                $authM->remove($role);
                echo "$role_name is removed \n";
            }
        }

        $roles = ["finance_manager"=> "资金管理员", 
            "operation_manager"=> "运营人员",
            "developer"=> "研发人员", ];

        foreach($roles as $role_name => $title){
            $role = $authM->createRole($role_name);
            $authM->add($role);
            $authM->addChild($admin, $role);
            echo "$role_name is created \n";
        }
        echo " Done \n";

    }

    public function down()
    {
        echo "m150807_065144_tidy_roles cannot be reverted.\n";

        return false;
    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
