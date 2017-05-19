<?php

use yii\db\Schema;
use console\BaseMigration;

class m150717_132102_add_cloumns_for_corp extends BaseMigration
{
    public function up()
    {
        $sqls = "
   alter table jz_task add face_requirement smallint(6) not null default 0;
   alter table jz_task add talk_requirement smallint(6) not null default 0;
   alter table jz_task add weight_requirement smallint(6) not null default 0;
   alter table jz_task add health_certificated smallint(6) not null default 0;

    alter table jz_company add intro text;
    alter table jz_company add service            varchar(256)  ;
    alter table jz_company add corp_type          varchar(256)  ;
    alter table jz_company add corp_size          varchar(256)  ;
    alter table jz_company add person_name        varchar(256)  ;
    alter table jz_company add person_idcard      varchar(256)  ;
    alter table jz_company add person_idcard_pic  varchar(512)  ;
    alter table jz_company add corp_name          varchar(256)  ;
    alter table jz_company add corp_idcard        varchar(256)  ;
    alter table jz_company add corp_idcard_pic    varchar(512)  ;
            ";
        $this->execSqls($sqls);

    }

    public function down()
    {
        echo "m150717_132102_add_cloumns_for_corp cannot be reverted.\n";

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
