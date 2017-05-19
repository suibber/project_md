<?php

use yii\db\Schema;
use console\BaseMigration;

class m151010_060708_task_week extends BaseMigration
{
    public function up()
    {
        $sqls = "
CREATE TABLE `jz_tasktime` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dayofweek` smallint(6) NOT NULL COMMENT '周几',
  `morning` tinyint(1) NOT NULL DEFAULT '0' COMMENT '上午',
  `afternoon` tinyint(1) NOT NULL DEFAULT '0' COMMENT '下午',
  `evening` tinyint(1) NOT NULL DEFAULT '0' COMMENT '晚上',
  `task_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_jz_tasktime_jz_task1_idx` (`task_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
            ";
        return $this->execSqls($sqls);
    }

    public function down()
    {
        echo "m150922_022504_daka cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
