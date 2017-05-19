<?php

use yii\db\Schema;
use console\BaseMigration;

class m150807_092448_user_account extends BaseMigration
{
   public function up()
    {
        $sqls = "
CREATE TABLE `jz_user_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `defalut_withdraw_type` tinyint(4) DEFAULT '10' COMMENT '默认提款方式',
  `money_all` decimal(10,2) DEFAULT '0.00' COMMENT '全部收入',
  `money_balance` decimal(10,2) DEFAULT '0.00' COMMENT '可提现收入',
  `money_success` decimal(10,2) DEFAULT '0.00' COMMENT '已提现收入',
  `money_doing` decimal(10,2) DEFAULT '0.00' COMMENT '提现中收入',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `fk_jz_user_account_jz_user1_idx` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

ALTER TABLE `jz_account_event` ADD `task_gid` varchar(100) DEFAULT '0';
        ";
        $this->execSqls($sqls);
    }
    public function down()
    {
        $this->dropTable('jz_user_account');
        return true;
    }
}
