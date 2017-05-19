<?php

use yii\db\Schema;
use console\BaseMigration;

class m150806_091206_add_pinyin_and_short_name_to_city_table extends BaseMigration
{
    public function up()
    {
        $sqls = "
            alter table jz_district add short_name varchar(500);
            alter table jz_district add pinyin varchar(500);
            alter table jz_district add short_pinyin varchar(500);
            alter table jz_district add is_hot boolean not null default false;
            alter table jz_district add is_alive boolean not null default false;
            ";
        $this->execSqls($sqls);
    }

    public function down()
    {
        echo "m150806_091206_add_pinyin_and_short_name_to_city_table cannot be reverted.\n";

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
