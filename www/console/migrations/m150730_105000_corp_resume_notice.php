<?php

use yii\db\Schema;
use console\BaseMigration;

class m150730_105000_corp_resume_notice extends BaseMigration
{
    public function up()
    {
        $sqls = "
CREATE TABLE `jz_task_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `task_id` int(11) NOT NULL COMMENT '任务ID（1对1关系）',
  `type` tinyint(4) DEFAULT '1' COMMENT '类型：面试、培训',
  `meet_time` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT '约定时间',
  `place` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '约定地点',
  `linkman` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '联系人姓名',
  `phone` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '联系人电话',
  `created_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

        ";
        $this->execSqls($sqls);
    }

    public function down()
    {
        $this->dropTable('jz_task_notice');
        return true;
    }
}
