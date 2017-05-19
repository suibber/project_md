e yii\db\Schema;
use console\BaseMigration;
class m150707_233142_weichat_push extends BaseMigration
{
    public function up()
    {
        $sqls = "
CREATE TABLE `jz_weichat_accesstoken` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `access_token` varchar(200) DEFAULT NULL COMMENT '΢�ŵ�access_token',
  `expires_in` int(11) DEFAULT NULL COMMENT '����ʱ��',
  `created_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '����ʱ��',
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '����ʱ��',
  `used_times` int(11) DEFAULT '0' COMMENT 'ʹ�ô���',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
CREATE TABLE `jz_weichat_push_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `push_group` varchar(200) DEFAULT NULL COMMENT '���ͷ��飨��Ⱥ��200�ˣ�����η�Ϊһ�飩',
  `openid` varchar(200) DEFAULT NULL COMMENT '�û�΢��ID',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '����ʱ��',
  `result` varchar(100) DEFAULT NULL COMMENT '���ͽ��',
  `return_msg` varchar(400) DEFAULT NULL COMMENT '���ͷ�����Ϣ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
CREATE TABLE `jz_weichat_push_quality_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `gid` varchar(100) DEFAULT NULL COMMENT '���������gid',
  `title` varchar(200) DEFAULT NULL COMMENT '��Ϣ����',
  `company_name` varchar(200) DEFAULT NULL COMMENT '��˾����',
  `task_name` varchar(200) DEFAULT NULL COMMENT '��������',
  `task_type` varchar(100) DEFAULT NULL COMMENT '�������',
  `location` varchar(100) DEFAULT NULL COMMENT '�����ص�',
  `price` varchar(100) DEFAULT NULL COMMENT 'н��',
  `created_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '����ʱ��',
  `updated_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '�޸�ʱ��',
  `has_pushed` tinyint(4) DEFAULT '0' COMMENT '�Ƿ����͹�',
  `pushed_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '����ʱ��',
  `push_group` varchar(100) DEFAULT NULL COMMENT '���ͷ��飬���ڲ鿴��־�б������͵��������',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
CREATE TABLE `jz_weichat_push_set_pushset` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `push_time` tinyint(4) DEFAULT '0' COMMENT '����ʱ��ѡ��',
  `push_way` tinyint(4) DEFAULT '0' COMMENT 'ѡ�����ͷ�ʽ',
  `status` tinyint(4) DEFAULT '1' COMMENT '״̬',
  `template_push_id` int(11) DEFAULT '0' COMMENT 'ѡ��������Ϣ�б�ģ��',
  `template_weichat_id` int(11) DEFAULT '0' COMMENT 'ѡ���Ӧ��΢��ģ��',
  `created_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '����ʱ��',
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '����ʱ��',
  `latest_push_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '�ϴ�����ʱ��',
  `latest_push_group` varchar(100) DEFAULT NULL COMMENT '�ϴ����ͷ��飬���ڲ鿴��־�б������͵��������',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
CREATE TABLE `jz_weichat_push_set_template_push_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `task_id` varchar(200) DEFAULT NULL COMMENT '����ID��gid',
  `template_push_id` int(11) DEFAULT NULL COMMENT '����������Ϣ�б�ģ��',
  `display_order` smallint(6) DEFAULT '1' COMMENT '����Խ��Խ��ǰ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
CREATE TABLE `jz_weichat_push_set_template_push_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(500) DEFAULT NULL COMMENT 'ģ�����',
  `created_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '����ʱ��',
  `updated_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '�޸�ʱ��',
  `status` tinyint(4) DEFAULT '1' COMMENT '״̬��1������0ɾ����',
  `create_user` int(11) DEFAULT NULL COMMENT '������',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
CREATE TABLE `jz_weichat_push_set_template_weichat` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(500) DEFAULT NULL COMMENT 'ģ�����',
  `created_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '����ʱ��',
  `updated_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '�޸�ʱ��',
  `status` tinyint(4) DEFAULT '1' COMMENT '״̬',
  `create_user` int(11) DEFAULT NULL COMMENT '������',
  `weichat_template_id` varchar(200) DEFAULT NULL COMMENT '��Ӧ��΢��ģ��ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `jz_weichat_user_info` ADD `is_receive_nearby_msg` tinyint(4) DEFAULT '0' COMMENT '�Ƿ���????�Ÿ�����ְ������';
        ";
        $this->execSqls($sqls);
    }
    public function down()
    {
        $this->dropTable('jz_weichat_accesstoken');
        $this->dropTable('jz_weichat_push_quality_task');
        $this->dropTable('jz_weichat_push_set_pushset');
        $this->dropTable('jz_weichat_push_set_template_push_item'); 
        $this->dropTable('jz_weichat_push_set_template_push_list');
        $this->dropTable('jz_weichat_push_set_template_weichat');
        $this->dropTable('jz_weichat_push_log');
        return true;
    }
}
