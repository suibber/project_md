<?php

use yii\db\Schema;
use console\BaseMigration;

class m150710_090546_config_recommend extends BaseMigration
{
    public function up()
    {
        $sqls = "
CREATE TABLE `jz_config_recommend` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `task_id` varchar(200) DEFAULT NULL COMMENT '任务ID，gid',
  `type` int(11) DEFAULT '0' COMMENT '类型，如m端首页推荐，网页端首页推荐等',
  `city_id` int(11) DEFAULT '3' COMMENT '城市ID',
  `display_order` smallint(6) DEFAULT '1' COMMENT '排序，越大越靠前',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
        ";
        $this->execSqls($sqls);
    }

    public function down()
    {
        $this->dropTable('jz_config_recommend');
        return true;
    }
}
