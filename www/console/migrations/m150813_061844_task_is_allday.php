<?php

use yii\db\Schema;
use console\BaseMigration;

class m150813_061844_task_is_allday extends BaseMigration
{
   public function up()
    {
        $sqls = "
ALTER TABLE `jz_task` ADD `is_allday` TINYINT(4) DEFAULT 0 COMMENT '不限工作时间';
        ";
        $this->execSqls($sqls);
    }
    public function down()
    {
        return true;
    }
}
