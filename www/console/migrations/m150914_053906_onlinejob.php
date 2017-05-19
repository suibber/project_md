<?php

use yii\db\Schema;
use console\BaseMigration;

class m150914_053906_onlinejob extends BaseMigration
{
    public function up()
    {
        $sqls = "
CREATE TABLE `jz_task_onlinejob`(
 `id` INT(11) NOT NULL auto_increment COMMENT '在线任务ID',
 `task_id` int(11) NOT NULL COMMENT '任务',
 `name` VARCHAR(200) COLLATE utf8_unicode_ci DEFAULT NULL comment '名称',
 `intro` VARCHAR(500) COLLATE utf8_unicode_ci DEFAULT NULL comment '介绍',
 `download_android` VARCHAR(200) COLLATE utf8_unicode_ci  DEFAULT NULL comment '安卓下载链接',
 `download_ios` VARCHAR(200) COLLATE utf8_unicode_ci DEFAULT NULL comment 'IOS下载链接',
 `audit_cycle` TINYINT DEFAULT 0 COMMENT '审核周期',
 `need_phonenum` TINYINT(4)  DEFAULT 0 comment '需要手机号',
 `need_username` TINYINT(4)  DEFAULT 0 comment '需要用户名',
 `need_person_idcard` TINYINT(4)  DEFAULT 0 comment '需要身份证',
 primary key (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci comment '在线任务表';

CREATE TABLE `jz_task_onlinejob_needinfo`(
 `id` INT(11) NOT NULL auto_increment COMMENT '附加信息ID',
 `status` TINYINT(4) DEFAULT 0 COMMENT '状态',
 `task_id` INT(11) DEFAULT 0 COMMENT '任务id',
 `group_id` TINYINT(4) DEFAULT 0 COMMENT '分组id',
 `type` tinyint(4) DEFAULT '0' COMMENT '类型（图片、文本）',
 `display_order` TINYINT(4) DEFAULT 0 COMMENT '排序',
 `intro` VARCHAR(200) COLLATE utf8_unicode_ci DEFAULT NULL comment '名称',
 `intro_pic` VARCHAR(500) COLLATE utf8_unicode_ci DEFAULT NULL comment '图片',
 `url` varchar(400) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'URL',
 `is_required` TINYINT DEFAULT 0 COMMENT '是否需要填写',
 `is_must` TINYINT DEFAULT 0 COMMENT '是否必填',
 primary key (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci comment '任务需要填写信息配置';

CREATE TABLE `jz_task_applicant_onlinejob`(
 `id` INT(11) NOT NULL auto_increment COMMENT '在线任务提交id',
 `created_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
 `updated_time` timestamp NULL DEFAULT NULL COMMENT '修改时间',
 `status` TINYINT(4) DEFAULT 0 COMMENT '状态',
 `reason` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '审核未通过原因',
 `app_id` INT(11) DEFAULT 0 COMMENT '任务报名id',
 `user_id` INT(11) DEFAULT 0 COMMENT '用户id',
 `task_id` INT(11) DEFAULT 0 COMMENT '任务id',
 `needinfo` text COLLATE utf8_unicode_ci DEFAULT NULL comment '序列化的任务提交信息',
 `has_sync_wechat_pic` tinyint(4) default 0 comment '是否已经同步微信上传图片',
 `need_phonenum` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL comment '手机号',
 `need_username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL comment '用户名',
 `need_person_idcard` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL comment '身份证',
 primary key (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci comment '在线任务提交信息';
            ";
        return $this->execSqls($sqls);
    }

    public function down()
    {
        echo "m150914_053906_onlinejob cannot be reverted.\n";

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
