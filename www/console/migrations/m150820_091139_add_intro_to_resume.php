<?php

use yii\db\Schema;
use console\BaseMigration;

class m150820_091139_add_intro_to_resume extends BaseMigration
{
    public function up()
    {
        $sqls = "
            alter table jz_resume add intro text default '';
            ";
        return $this->execSqls($sqls);

    }

    public function down()
    {
        echo "m150820_091139_add_intro_to_resume cannot be reverted.\n";

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
