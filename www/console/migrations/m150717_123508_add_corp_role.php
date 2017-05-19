<?php

use yii\db\Schema;
use yii\db\Migration;

class m150717_123508_add_corp_role extends Migration
{
    public function up()
    {

        $auth = Yii::$app->authManager;

        $corp = $auth->createRole('corp');
        $auth->add($corp);

    }

    public function down()
    {
        echo "m150717_123508_add_corp_role cannot be reverted.\n";

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
