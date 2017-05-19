<?php

use yii\db\Schema;
use console\BaseMigration;

class m150711_104819_data_daily extends BaseMigration
{
    public function up()
    {
        $sqls = "
CREATE TABLE `jz_data_daily` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `type` tinyint(4) DEFAULT '0' COMMENT '统计分类，1：核心指标-用户端、2：核心指标-职位、3：微信日报',
  `date` date DEFAULT NULL COMMENT '统计的日期',
  `key` varchar(255) DEFAULT NULL COMMENT '统计项',
  `value` int(11) DEFAULT '0' COMMENT '统计数值',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `city_id` int(11) DEFAULT '0' COMMENT '城市维度',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1579 DEFAULT CHARSET=utf8;

CREATE TABLE `jz_weichat_user_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `openid` varchar(200) DEFAULT '' COMMENT '微信ID',
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `event_type` tinyint(4) DEFAULT '0' COMMENT '事件类型(1关注、2取消关注)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

ALTER TABLE `jz_user` ADD `origin` VARCHAR(200) DEFAULT NULL COMMENT '渠道来源';
ALTER TABLE `jz_task_applicant` ADD `origin` VARCHAR(200) DEFAULT NULL COMMENT '渠道来源';
        ";
        $this->execSqls($sqls);
    }

    public function down()
    {
        $this->dropTable('jz_data_daily');
        $this->dropTable('jz_weichat_user_log');
        return true;
    }
}
