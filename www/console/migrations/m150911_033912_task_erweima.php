<?php

use yii\db\Schema;
use console\BaseMigration;

class m150911_033912_task_erweima extends BaseMigration
{
    public function up()
    {
        $sqls = "
            alter table `jz_task` add `erweima_ticket` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '生成的二维码船票，用这个就能得到二维码了';
            alter table `jz_task` add `erweima_date` date DEFAULT '2015-01-01' COMMENT '二维码生成日期'
            ";
        return $this->execSqls($sqls);
    }

    public function down()
    {
        echo "m150911_033912_task_erweima cannot be reverted.\n";

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
