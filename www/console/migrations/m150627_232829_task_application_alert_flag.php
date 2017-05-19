<?php

use yii\db\Schema;
use console\BaseMigration;

class m150627_232829_task_application_alert_flag extends BaseMigration
{
    public function up()
    {
        $sqls = "
            alter table jz_task_applicant add company_alerted boolean default false;
            alter table jz_task_applicant add applicant_alerted boolean default false;
            ";
        $this->execSqls($sqls);
    }

    public function down()
    {
        echo "m150627_232829_task_application_alert_flag cannot be reverted.\n";

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
