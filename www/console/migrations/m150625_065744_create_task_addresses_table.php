<?php

use yii\db\Schema;
use console\BaseMigration;

class m150625_065744_create_task_addresses_table extends BaseMigration
{
    public function up()
    {

        $sqls = "
drop table if exists jz_task_address ;
CREATE TABLE IF NOT EXISTS `jz_task_address` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `province` VARCHAR(45) NULL,
  `city` VARCHAR(45) NULL,
  `district` VARCHAR(45) NULL,
  `lat` DOUBLE NOT NULL,
  `lng` DOUBLE NOT NULL,
  `task_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_lng_of_task_address` (`lng` ASC),
  INDEX `idx_lat_of_task_address` (`lng` ASC),
  INDEX `fk_jz_task_address_jz_task1_idx` (`task_id` ASC),
  INDEX `fk_jz_task_address_jz_user1_idx` (`user_id` ASC)
)
ENGINE = InnoDB";

        $this->execSqls($sqls);
    }

    public function down()
    {
        $sqls = "drop table if exists jz_task_address ";
        $this->execSqls($sqls);
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
