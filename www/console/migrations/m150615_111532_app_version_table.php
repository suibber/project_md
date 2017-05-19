<?php

use yii\db\Schema;
use console\BaseMigration;

class m150615_111532_app_version_table extends BaseMigration
{
    public function up()
    {
        $sqls = "
CREATE TABLE IF NOT EXISTS `jz_app_release_version` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `device_type` SMALLINT NOT NULL COMMENT '设备类型',
  `app_version` VARCHAR(45) NOT NULL COMMENT '应用版本',
  `html_version` VARCHAR(45) NOT NULL COMMENT 'html版本',
  `update_url` VARCHAR(1000) NULL COMMENT '升级链接',
  `release_time` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT '发布时间',
  PRIMARY KEY (`id`))
ENGINE = InnoDB
            ";
        $this->execSqls($sqls);

    }

    public function down()
    {
        return $this->dropTable('jz_app_release_version');
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
