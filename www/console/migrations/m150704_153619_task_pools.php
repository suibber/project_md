<?php

use yii\db\Schema;
use console\BaseMigration;

class m150704_153619_task_pools extends BaseMigration
{
    public function up()
    {

        $sqls = "
CREATE TABLE IF NOT EXISTS `jz_task_pool` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `company_name` VARCHAR(200) NOT NULL COMMENT '公司名',
  `city` VARCHAR(200) NULL COMMENT '城市',
  `origin_id` VARCHAR(45) NOT NULL COMMENT '来源id',
  `origin` VARCHAR(45) NOT NULL COMMENT '来源',
  `lng` FLOAT NULL,
  `lat` FLOAT NULL,
  `details` TEXT NOT NULL COMMENT '细节',
  `has_poi` TINYINT(1) NOT NULL DEFAULT false COMMENT '位置精准？',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `idx_unique_task_id` (`origin_id` ASC, `origin` ASC))
ENGINE = InnoDB 
            ";
        $this->execSqls($sqls);
    }

    public function down()
    {
        echo "m150704_153619_task_pools cannot be reverted.\n";

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
