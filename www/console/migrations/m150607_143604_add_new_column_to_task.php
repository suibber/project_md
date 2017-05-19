<?php

use yii\db\Schema;
use console\BaseMigration;

class m150607_143604_add_new_column_to_task extends BaseMigration
{
    public function up()
    {
        $sqls = "
            Alter table jz_resume add major varchar(500);
            Alter table jz_resume add job_wishes varchar(1000);
            Alter table jz_task add district_id int;
            alter table jz_task add company_id int;
            ";
        $this->execSqls($sqls);

    }

    public function down()
    {
        echo "m150607_143604_add_new_column_to_task cannot be reverted.\n";

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
