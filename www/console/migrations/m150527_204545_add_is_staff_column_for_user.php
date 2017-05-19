<?php

use yii\db\Schema;
use console\BaseMigration;

class m150527_204545_add_is_staff_column_for_user extends BaseMigration
{
    public function up()
    {
        $sqls = "
            alter table jz_user add is_staff bool not null default false;
            ";
        return $this->execSqls($sqls);
    }

    public function down()
    {
        echo "m150527_204545_add_is_staff_column_for_user cannot be reverted.\n";
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
