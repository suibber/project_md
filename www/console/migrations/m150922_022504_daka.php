<?php

use yii\db\Schema;
use console\BaseMigration;

class m150922_022504_daka extends BaseMigration
{
    public function up()
    {
        $sqls = "
alter table `ext_time_book_record` add `device_id` varchar(500) COLLATE utf8_unicode_ci NOT NULL;
alter table `ext_time_book_record` add `device_date` date DEFAULT NULL COMMENT '设备打卡日期';
            ";
        return $this->execSqls($sqls);
    }

    public function down()
    {
        echo "m150922_022504_daka cannot be reverted.\n";

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
