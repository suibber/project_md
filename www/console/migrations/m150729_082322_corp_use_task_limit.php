<?php

use yii\db\Schema;
use console\BaseMigration;

class m150729_082322_corp_use_task_limit extends BaseMigration
{
    public function up()
    {
        $sqls = "
  ALTER TABLE `jz_company` ADD `use_task_date` date DEFAULT NULL COMMENT '最近一次操作职位日期（增、改、刷新）';
  ALTER TABLE `jz_company` ADD `use_task_num` smallint(6) DEFAULT '0' COMMENT '最近一次操作职位当天，操作次数';
            ";
        return $this->execSqls($sqls);
    }

    public function down()
    {
        echo "m150729_082322_corp_use_task_limit cannot be reverted.\n";

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
