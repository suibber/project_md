<?php

use yii\db\Schema;
use console\BaseMigration;

class m150702_213044_add_some_columns extends BaseMigration
{
    public function up()
    {
        $sqls = "
            alter table jz_company add introduction text ;
            alter table jz_task_address add title varchar(200);
            ";
        $this->execSqls($sqls);

    }

    public function down()
    {
        echo "m150702_213044_add_some_columns cannot be reverted.\n";

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
