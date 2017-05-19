<?php

use yii\db\Schema;
use console\BaseMigration;

class m150820_061151_new_resume_attr extends BaseMigration
{
    public function up()
    {

        $sqls = "
            alter table jz_resume add weight integer;
            alter table jz_resume drop degree;
            alter table jz_resume add degree smallint;
            alter table jz_resume add has_emdical_cert boolean not null default false;
            ";
        return $this->execSqls($sqls);

    }

    public function down()
    {
        echo "m150820_061151_new_resume_attr cannot be reverted.\n";

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
