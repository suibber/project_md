<?php

use yii\db\Schema;
use console\BaseMigration;

class m150723_100510_weicaht_autoresponse extends BaseMigration
{
    public function up()
    {

        $sqls = "
CREATE TABLE `jz_weichat_autoresponse` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `type` tinyint(4) DEFAULT '0' COMMENT '类型：1关注、2自动回复',
  `status` tinyint(4) DEFAULT '1' COMMENT '状态：1正常、0删除',
  `keywords` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '关键字',
  `response_msg` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '自动回复内容',
  `created_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
            ";
        $this->execSqls($sqls);

    }

    public function down()
    {
        $this->dropTable('jz_weichat_autoresponse');
        return true;
    }
}
