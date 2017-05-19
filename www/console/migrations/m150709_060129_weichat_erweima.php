<?php

use yii\db\Schema;
use console\BaseMigration;

class m150709_060129_weichat_erweima extends BaseMigration
{
    public function up()
    {
        $sqls = "
ALTER TABLE `jz_weichat_user_info` ADD `origin_type` tinyint(4) DEFAULT 0 COMMENT '渠道来源-分类';

ALTER TABLE `jz_weichat_user_info` ADD `origin_detail` varchar(200) DEFAULT NULL COMMENT '渠道来源-详情';

CREATE TABLE `jz_weichat_erweima` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(200) DEFAULT NULL COMMENT '二维码名称',
  `comment` varchar(400) DEFAULT NULL COMMENT '二维码描述',
  `type` tinyint(4) DEFAULT '0' COMMENT '二维码类型，1-临时二维码7天有效，2-永久有效果仅能生成10W个',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '修改时间',
  `scene_id` varchar(100) DEFAULT '0' COMMENT '微信场景ID，用户扫描二维码后，微信推送消息附带此参数',
  `ticket` varchar(200) DEFAULT NULL COMMENT '生成的二维码船票，用这个就能得到二维码了',
  `after_msg` varchar(500) DEFAULT NULL COMMENT '用户扫码关注后订阅号推送的消息内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

CREATE TABLE `jz_weichat_erweima_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `erweima_id` int(11) DEFAULT '0' COMMENT '对应的二维码ID',
  `openid` varchar(200) DEFAULT NULL COMMENT '扫描关注者的微信id',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `has_bind` tinyint(4) DEFAULT '0' COMMENT '扫描之前是否已经绑定过',
  `follow_by_scan` tinyint(4) DEFAULT '0' COMMENT '是否通过扫描关注公众号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
        ";
        $this->execSqls($sqls);
    }

    public function down()
    {
        $this->dropTable('jz_weichat_erweima');
        $this->dropTable('jz_weichat_erweima_log');
        return true;
    }
}
