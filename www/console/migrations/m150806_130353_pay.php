<?php

use yii\db\Schema;
use console\BaseMigration;

class m150806_130353_pay extends BaseMigration
{
   public function up()
    {
        $sqls = "
drop table if exists jz_account_event;
CREATE TABLE `jz_account_event` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `date` date DEFAULT NULL COMMENT 'excel标记日期',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `value` decimal(10,2) NOT NULL COMMENT '变更金额',
  `operator_id` int(11) NOT NULL COMMENT '创建人',
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '变更时间',
  `balance` decimal(10,2) NOT NULL COMMENT '余额',
  `type` int(11) NOT NULL COMMENT '变更原因类型',
  `note` varchar(400) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '备注',
  `related_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '关联id（提现id 或 任务id）',
  PRIMARY KEY (`id`),
  KEY `fk_jz_account_event_jz_user1_idx` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

drop table if exists jz_withdraw_cash;
CREATE TABLE `jz_withdraw_cash` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `value` decimal(10,2) NOT NULL COMMENT '金额',
  `withdraw_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '提现时间',
  `type` smallint(6) NOT NULL COMMENT '打款方式',
  `payout_id` int(11) DEFAULT NULL COMMENT '打款明细',
  `status` smallint(6) NOT NULL COMMENT '状态',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后更改时间',
  `note` text COMMENT '备注',
  `operator_id` int(11) NOT NULL COMMENT '操作人',
  PRIMARY KEY (`id`),
  KEY `fk_jz_withdraw_cach_jz_user1_idx` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

drop table if exists jz_payout;
CREATE TABLE `jz_payout` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `gid` varchar(200) NOT NULL COMMENT '第三方流水号',
  `payout_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '支付时间',
  `value` decimal(10,2) NOT NULL COMMENT '支付金额',
  `type` smallint(6) NOT NULL COMMENT '打款方式 微信（线上） 银行卡（线下）',
  `account_id` varchar(500) NOT NULL COMMENT '收款账号',
  `account_owner` varchar(100) DEFAULT NULL COMMENT '收款人',
  `to_user_id` int(11) NOT NULL COMMENT '收款用户id',
  `status` smallint(6) NOT NULL COMMENT '结果',
  `operator_id` int(11) NOT NULL COMMENT '操作人',
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '录入时间',
  `note` text,
  `account_info` varchar(400) DEFAULT NULL COMMENT '开户行',
  PRIMARY KEY (`id`),
  KEY `fk_jz_payout_jz_user1_idx` (`to_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8;
        ";
        $this->execSqls($sqls);
    }
    public function down()
    {
        $this->dropTable('jz_account_event');
        $this->dropTable('jz_withdraw_cash');
        $this->dropTable('jz_payout');
        return true;
    }
}
