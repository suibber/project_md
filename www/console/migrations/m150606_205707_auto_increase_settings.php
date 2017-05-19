<?php

use yii\db\Schema;
use console\BaseMigration;

class m150606_205707_auto_increase_settings extends BaseMigration
{
    public function up()
    {
        $sqls = "
        ALTER TABLE `jz_address` CHANGE COLUMN `id` `id` INT(11) NOT NULL AUTO_INCREMENT  ;
        ALTER TABLE `jz_task` CHANGE COLUMN `id` `id` INT(11) NOT NULL AUTO_INCREMENT  ;
        ALTER TABLE `jz_service_type` CHANGE COLUMN `id` `id` INT(11) NOT NULL AUTO_INCREMENT  ;
            ";
        $this->execSqls($sqls);

    }

    public function down()
    {

        echo "Cannot be reverted.\n";

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
