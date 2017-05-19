<?php

use yii\db\Schema;
use console\BaseMigration;

class m150701_085538_jz_weichat_user_info extends BaseMigration
{
    public function up()
    {

        $sqls = "

drop table if exists `jz_weichat_user_info`;
CREATE TABLE `jz_weichat_user_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(200) DEFAULT NULL COMMENT '微信与公众号唯一关系ID',
  `userid` int(11) DEFAULT NULL COMMENT '用户ID',
  `status` smallint(6) DEFAULT '0' COMMENT '状态',
  `created_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `weichat_name` varchar(200) DEFAULT NULL COMMENT '用户微信姓名',
  `weichat_head_pic` varchar(200) DEFAULT NULL COMMENT '用户微信头像',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;
           ";
        $this->execSqls($sqls);
    }

    public function down()
    {
        $this->dropTable('jz_weichat_user_info');
        return true;
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
