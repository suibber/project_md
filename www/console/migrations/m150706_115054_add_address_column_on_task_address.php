<?php

use yii\db\Schema;
use console\BaseMigration;

class m150706_115054_add_address_column_on_task_address extends BaseMigration
{
    public function up()
    {
        $sqls = "
            alter table jz_task_address add address varchar(500);
            ";
        $this->execSqls($sqls);

    }

    public function down()
    {
        echo "m150706_115054_add_address_column_on_task_address cannot be reverted.\n";

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
