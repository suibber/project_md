<?php

use yii\db\Schema;
use console\BaseMigration;

class m150910_082603_update_company_name extends BaseMigration
{
    public function up()
    {
        $sqls = "
            UPDATE `jz_task` SET company_name='米多多运营中心' WHERE company_name LIKE '%校联邦%';
            UPDATE `jz_company` SET `name`='米多多运营中心' WHERE `name` LIKE '%校联邦%';
            ";
        return $this->execSqls($sqls);
    }

    public function down()
    {
        echo "m150910_082603_update_company_name cannot be reverted.\n";

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
