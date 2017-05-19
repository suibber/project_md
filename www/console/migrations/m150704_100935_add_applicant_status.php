<?php

use yii\db\Schema;
use console\BaseMigration;

class m150704_100935_add_applicant_status extends BaseMigration
{
    public function up()
    {
        $sqls = "
            alter table jz_task_applicant add status smallint not null default 0;
            ";
        $this->execSqls($sqls);
    }

    public function down()
    {
        echo "m150704_100935_add_applicant_status cannot be reverted.\n";

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
