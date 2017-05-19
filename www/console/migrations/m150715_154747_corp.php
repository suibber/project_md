<?php

use yii\db\Schema;
use console\BaseMigration;

class m150715_154747_corp extends BaseMigration
{
    public function up()
    {

        $sqls = "
        alter table jz_task_applicant add have_read smallint default 0;
        alter table jz_company change column name name varchar(500) default null;
        alter table jz_company drop column address_id;
        alter table jz_company add column service varchar(256) default null;
        alter table jz_company add column corp_type varchar(256) default null;
        alter table jz_task add column is_longterm smallint default 0;
        alter table jz_task add column sms_phonenum varchar(100) default null;

            ";
        $this->execSqls($sqls);

    }

    public function down()
    {
        echo "m150715_154747_corp cannot be reverted.\n";

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
