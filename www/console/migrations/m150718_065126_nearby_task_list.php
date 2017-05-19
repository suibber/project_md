<?php

use yii\db\Schema;
use console\BaseMigration;

class m150718_065126_nearby_task_list extends BaseMigration
{
    public function up()
    {
        $sqls = "

ALTER table `jz_task` ADD `order_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '默认排序时间';

ALTER table `jz_task` ADD `recommend` tinyint(4) DEFAULT '0' COMMENT '是否为优单';
        ";
        $this->execSqls($sqls);
    }

    public function down()
    {
        return true;
    }
}
