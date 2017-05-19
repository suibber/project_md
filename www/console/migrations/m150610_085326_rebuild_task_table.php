<?php

use yii\db\Schema;
use console\BaseMigration;

class m150610_085326_rebuild_task_table extends BaseMigration
{
    public function up()
    {
        $sqls = "
            ALTER TABLE `jz_task` 
            DROP COLUMN `address_id`,
            ADD COLUMN `address` VARCHAR(500) NOT NULL,
            ADD COLUMN `company_name` VARCHAR(500) NOT NULL,
            DROP INDEX `fk_jz_order_jz_address1_idx` ;
        ";

        $this->execSqls($sqls);

    }

    public function down()
    {
        echo "m150610_085326_rebuild_task_table cannot be reverted.\n";

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
