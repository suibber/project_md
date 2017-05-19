<?php

use yii\db\Schema;
use console\BaseMigration;

class m150810_080421_user_account_locked extends BaseMigration
{
   public function up()
    {
        $sqls = "
ALTER TABLE `jz_account_event` ADD `locked` tinyint(4) DEFAULT '0' COMMENT '处理中，锁住';
        ";
        $this->execSqls($sqls);
    }
    public function down()
    {
        return true;
    }
}
