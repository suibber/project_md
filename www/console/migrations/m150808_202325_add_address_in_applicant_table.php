<?php

use yii\db\Schema;
use console\BaseMigration;

class m150808_202325_add_address_in_applicant_table extends BaseMigration
{
    public function up()
    {
        $sqls = "
            alter table jz_task_applicant add address_id int;
            ";
        return $this->execSqls($sqls);

    }

    public function down()
    {
        echo "m150808_202325_add_address_in_applicant_table cannot be reverted.\n";

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
