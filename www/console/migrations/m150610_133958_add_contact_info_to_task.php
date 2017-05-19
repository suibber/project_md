<?php

use yii\db\Schema;
use console\BaseMigration;

class m150610_133958_add_contact_info_to_task extends BaseMigration
{
    public function up()
    {
        $sqls = "
            alter table jz_task add company_introduction text;
            alter table jz_task add contact varchar(500);
            alter table jz_task add contact_phonenum varchar(100);
            ";
        $this->execSqls($sqls);

    }

    public function down()
    {
        echo "m150610_133958_add_contact_info_to_task cannot be reverted.\n";

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
