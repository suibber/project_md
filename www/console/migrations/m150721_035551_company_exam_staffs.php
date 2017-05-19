<?php

use yii\db\Schema;
use console\BaseMigration;

class m150721_035551_company_exam_staffs extends BaseMigration
{
    public function up()
    {
        $sqls = "
alter table jz_company add exam_status smallint not null default 0;
alter table jz_company add exam_note text;
            ";
        $this->execSqls($sqls);
    }

    public function down()
    {
        echo "m150721_035551_company_exam_staffs cannot be reverted.\n";

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
