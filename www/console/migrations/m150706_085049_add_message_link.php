<?php

use yii\db\Schema;
use console\BaseMigration;

class m150706_085049_add_message_link extends BaseMigration
{
    public function up()
    {
        $sqls = "alter table jz_message add link varchar(500)";
        $this->execSqls($sqls);
    }

    public function down()
    {
        echo "m150706_085049_add_message_link cannot be reverted.\n";

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
