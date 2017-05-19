<?php

use yii\db\Schema;
use console\BaseMigration;

class m150614_230713_add_device_table extends BaseMigration
{
    public function up()
    {

        $sqls = "
CREATE TABLE IF NOT EXISTS `jz_device` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `type` SMALLINT NULL DEFAULT 0 COMMENT '设备类型',
  `device_id` VARCHAR(500) NOT NULL,
  `user_id` INT NOT NULL DEFAULT 0 COMMENT '用户',
  `push_id` VARCHAR(500) NULL COMMENT '推送id',
  `updated_time` TIMESTAMP NOT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  `created_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `access_token` VARCHAR(500) NULL,
  `device_info` VARCHAR(200) NULL COMMENT '设备信息',
  `app_version` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_jz_device_jz_user1_idx` (`user_id` ASC),
  INDEX `idx_device_device_id` (`device_id` ASC) USING HASH
)
ENGINE = InnoDB
";
        $this->execSqls($sqls);
    }

    public function down()
    {
        return $this->dropTable('jz_device');
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
