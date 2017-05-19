<?php

use yii\db\Schema;
use console\BaseMigration;

class m150610_061558_add_invited_by_to_user extends BaseMigration
{
    public function up()
    {
        $sqls = "
           ALTER TABLE `jz_user` 
            ADD COLUMN `invited_by` INT NOT NULL DEFAULT 0 AFTER `is_staff`,
            ADD INDEX `invited_user_id` (`invited_by` ASC);
            update jz_district set name =  REPLACE(name, '市辖区', '') where 1=1;
            ";
        $this->execSqls($sqls);

    }

    public function down()
    {
        echo "m150610_061558_add_invited_by_to_user cannot be reverted.\n";

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
