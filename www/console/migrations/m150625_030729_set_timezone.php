<?php

use yii\db\Schema;
use console\BaseMigration;

class m150625_030729_set_timezone extends BaseMigration
{
    public function up()
    {
        $sqls = "set time_zone = '+8:00';";
        $this->execSqls($sqls);
    }

    public function down()
    {
        echo "m150625_030729_set_timezone cannot be reverted.\n";

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
