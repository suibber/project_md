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
  `openid` varchar(200) DEFAULT NULL COMMENT '΢���빫�ں�Ψһ��ϵID',
  `userid` int(11) DEFAULT NULL COMMENT '�û�ID',
  `status` smallint(6) DEFAULT '0' COMMENT '״̬',
  `created_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '����ʱ��',
  `updated_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '����ʱ��',
  `weichat_name` varchar(200) DEFAULT NULL COMMENT '�û�΢������',
  `weichat_head_pic` varchar(200) DEFAULT NULL COMMENT '�û�΢��ͷ��',
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
