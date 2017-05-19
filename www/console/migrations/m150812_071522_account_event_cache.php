<?php

use yii\db\Schema;
use console\BaseMigration;

class m150812_071522_account_event_cache extends BaseMigration
{
   public function up()
    {
        $sqls = "
alter table jz_account_event convert to character set utf8 collate utf8_unicode_ci;
CREATE TABLE `jz_account_event_cache` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `date` date DEFAULT NULL COMMENT 'excel标记日期',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `value` decimal(10,2) NOT NULL COMMENT '变更金额',
  `operator_id` int(11) NOT NULL COMMENT '创建人',
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '变更时间',
  `balance` decimal(10,2) NOT NULL COMMENT '余额',
  `type` int(11) NOT NULL COMMENT '变更原因类型',
  `note` varchar(400) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '备注',
  `related_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '关联id（提现id 或 任务id）',
  `task_gid` varchar(100) COLLATE utf8_unicode_ci DEFAULT '0',
  `locked` tinyint(4) DEFAULT '0' COMMENT '处理中，锁住',
  PRIMARY KEY (`id`),
  KEY `fk_jz_account_event_jz_user1_idx` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=431 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
        ";
        $this->execSqls($sqls);
    }
    public function down()
    {
        return true;
    }
}
