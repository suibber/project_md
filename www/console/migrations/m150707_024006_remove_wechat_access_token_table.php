<?php

use yii\db\Schema;
use yii\db\Migration;

class m150707_024006_remove_wechat_access_token_table extends Migration
{
    public function up()
    {
        $this->dropTable('jz_weichat_accesstoken');
        echo "DONE！\n";
        return true;
    }

    public function down()
    {
        echo "m150707_024006_remove_wechat_access_token_table cannot be reverted.\n";

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
