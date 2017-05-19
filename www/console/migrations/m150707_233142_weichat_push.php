e yii\db\Schema;
use console\BaseMigration;
class m150707_233142_weichat_push extends BaseMigration
{
    public function up()
    {
        $sqls = "
CREATE TABLE `jz_weichat_accesstoken` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `access_token` varchar(200) DEFAULT NULL COMMENT '微信的access_token',
  `expires_in` int(11) DEFAULT NULL COMMENT '过期时间',
  `created_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `used_times` int(11) DEFAULT '0' COMMENT '使用次数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
CREATE TABLE `jz_weichat_push_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `push_group` varchar(200) DEFAULT NULL COMMENT '推送分组（如群推200人，则这次分为一组）',
  `openid` varchar(200) DEFAULT NULL COMMENT '用户微信ID',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '推送时间',
  `result` varchar(100) DEFAULT NULL COMMENT '推送结果',
  `return_msg` varchar(400) DEFAULT NULL COMMENT '推送返回信息',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
CREATE TABLE `jz_weichat_push_quality_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `gid` varchar(100) DEFAULT NULL COMMENT '具体任务的gid',
  `title` varchar(200) DEFAULT NULL COMMENT '消息标题',
  `company_name` varchar(200) DEFAULT NULL COMMENT '公司名称',
  `task_name` varchar(200) DEFAULT NULL COMMENT '任务名称',
  `task_type` varchar(100) DEFAULT NULL COMMENT '任务类别',
  `location` varchar(100) DEFAULT NULL COMMENT '工作地点',
  `price` varchar(100) DEFAULT NULL COMMENT '薪资',
  `created_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  `has_pushed` tinyint(4) DEFAULT '0' COMMENT '是否推送过',
  `pushed_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '推送时间',
  `push_group` varchar(100) DEFAULT NULL COMMENT '推送分组，用于查看日志中本次推送的相关数据',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
CREATE TABLE `jz_weichat_push_set_pushset` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `push_time` tinyint(4) DEFAULT '0' COMMENT '推送时间选择',
  `push_way` tinyint(4) DEFAULT '0' COMMENT '选择推送方式',
  `status` tinyint(4) DEFAULT '1' COMMENT '状态',
  `template_push_id` int(11) DEFAULT '0' COMMENT '选择推送消息列表模板',
  `template_weichat_id` int(11) DEFAULT '0' COMMENT '选择对应的微信模板',
  `created_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `latest_push_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '上次推送时间',
  `latest_push_group` varchar(100) DEFAULT NULL COMMENT '上次推送分组，用于查看日志中本次推送的相关数据',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
CREATE TABLE `jz_weichat_push_set_template_push_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `task_id` varchar(200) DEFAULT NULL COMMENT '任务ID，gid',
  `template_push_id` int(11) DEFAULT NULL COMMENT '所属推送消息列表模板',
  `display_order` smallint(6) DEFAULT '1' COMMENT '排序，越大越靠前',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
CREATE TABLE `jz_weichat_push_set_template_push_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(500) DEFAULT NULL COMMENT '模板标题',
  `created_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  `status` tinyint(4) DEFAULT '1' COMMENT '状态（1正常，0删除）',
  `create_user` int(11) DEFAULT NULL COMMENT '创建人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
CREATE TABLE `jz_weichat_push_set_template_weichat` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(500) DEFAULT NULL COMMENT '模板标题',
  `created_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  `status` tinyint(4) DEFAULT '1' COMMENT '状态',
  `create_user` int(11) DEFAULT NULL COMMENT '创建人',
  `weichat_template_id` varchar(200) DEFAULT NULL COMMENT '对应的微信模板ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `jz_weichat_user_info` ADD `is_receive_nearby_msg` tinyint(4) DEFAULT '0' COMMENT '是否接鏀????信附近兼职的推送';
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
