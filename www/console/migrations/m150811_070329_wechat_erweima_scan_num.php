<?php

use yii\db\Schema;
use console\BaseMigration;

class m150811_070329_wechat_erweima_scan_num extends BaseMigration
{
   public function up()
    {
        $sqls = "
ALTER TABLE `jz_weichat_erweima` ADD `scan_num` int(11) DEFAULT '0' COMMENT '扫描次数';
        ";
        $this->execSqls($sqls);
    }
    public function down()
    {
        return true;
    }
}
