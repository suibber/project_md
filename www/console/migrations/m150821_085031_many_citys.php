<?php

use yii\db\Schema;
use console\BaseMigration;

class m150821_085031_many_citys extends BaseMigration
{
    public function up()
    {
        $sqls = "
CREATE TABLE `jz_config_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '广告位ID',
  `status` tinyint(4) DEFAULT '0' COMMENT '状态',
  `city_id` int(11) DEFAULT '0' COMMENT '所属城市ID',
  `type` tinyint(4) DEFAULT '0' COMMENT '类型，全国OR城市',
  `display_order` tinyint(4) DEFAULT '1' COMMENT '排序，越大越靠前',
  `title` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '标题',
  `pic` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '图片地址',
  `url` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '链接地址',
  `offline_date` date DEFAULT NULL COMMENT '下线日期',
  `created_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
            ";
        return $this->execSqls($sqls);

    }

    public function down()
    {
        $this->dropTable('jz_config_banner');
        return true;
    }
}
