<?php

use yii\db\Schema;
use console\BaseMigration;

class m150527_010243_offline_order extends BaseMigration
{
    public function up()
    {
        $sqls = "alter table jz_offline_order add from_date date not null;
            alter table jz_offline_order add to_date date not null;
            alter table jz_offline_order add plan_quantity int not null;
            alter table jz_offline_order add final_quantity int default 0;
            alter table jz_offline_order add plan_fee int not null;
            alter table jz_offline_order add final_fee int not null default 0;
            alter table jz_offline_order drop date;
             alter table jz_offline_order drop fee;
             alter table jz_offline_order drop pm_id;
            alter table jz_offline_order drop worker_quntity; ";
        $this->execSqls($sqls);
    }

    public function down()
    {
        $sqls = "alter table jz_offline_order drop from_date;
            alter table jz_offline_order drop to_date;
            alter table jz_offline_order drop plan_quantity;
            alter table jz_offline_order drop final_quantity;
            alter table jz_offline_order drop plan_fee;
            alter table jz_offline_order drop final_fee;
            alter table jz_offline_order add date date not null;
            alter table jz_offline_order add fee int not null;
            alter table jz_offline_order add pm_id int;
            alter table jz_offline_order add worker_quntity int default 0; ";
        $this->execSqls($sqls);
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
