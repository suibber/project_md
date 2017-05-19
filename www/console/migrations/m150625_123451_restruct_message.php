<?php

use yii\db\Schema;
use console\BaseMigration;

class m150625_123451_restruct_message extends BaseMigration
{
    public function up()
    {

        $sqls = "

drop table if exists `jz_message`;
CREATE TABLE `jz_message` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `read_flag` TINYINT(1) NOT NULL DEFAULT false,
  `message` TEXT NOT NULL,
  `title` VARCHAR(100) NOT NULL,
  `created_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `has_sent` TINYINT(1) NOT NULL DEFAULT false COMMENT '已发送',
  `type` SMALLINT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `fk_jz_message_jz_user1_idx` (`user_id` ASC)
)
ENGINE = InnoDB;

drop table if exists `jz_sys_message`;
CREATE TABLE `jz_sys_message` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(200) NULL COMMENT '标题',
  `content` TEXT NULL COMMENT '内容',
  `created_time` TIMESTAMP NULL DEFAULT current_timestamp COMMENT '创建时间',
  `type` SMALLINT NOT NULL DEFAULT 0 COMMENT '类型',
  `created_by` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_jz_sys_message_jz_user1_idx` (`created_by` ASC)
)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `jz_user_readed_sys_message` (
  `sys_message_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`sys_message_id`, `user_id`),
  Unique index `idx_user_readed_sys_message` (`user_id`, `sys_message_id`)
)
ENGINE = InnoDB
           ";
        $this->execSqls($sqls);
    }

    public function down()
    {
        $this->dropTable('jz_sys_message');
        $this->dropTable('jz_user_readed_sys_message');
        $this->dropTable('jz_message');
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
