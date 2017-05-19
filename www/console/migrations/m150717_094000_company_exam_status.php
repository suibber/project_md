<?php

use yii\db\Schema;
use console\BaseMigration;

class m150717_094000_company_exam_status extends BaseMigration
{
    public function up()
    {
        $sqls = "
            alter table jz_company add exam_result smallint not null default 0;
            ";
        $this->execSqls($sqls);

    }

    public function down()
    {
        echo "m150717_094000_company_exam_status cannot be reverted.\n";

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
