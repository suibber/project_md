<?php

use yii\db\Schema;
use console\BaseMigration;

class m150703_195830_complaint extends BaseMigration
{
    public function up()
    {
        $sqls = "
drop table if exists `jz_complaint`;
CREATE TABLE IF NOT EXISTS `jz_complaint` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(100),
  `content` TEXT NULL,
  `task_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `created_time` TIMESTAMP NULL DEFAULT current_timestamp,
  `phonenum` varchar(100) not NULL ,
  `status` SMALLINT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `fk_jz_complaint_jz_task1_idx` (`task_id` ASC),
  INDEX `fk_jz_complaint_jz_user1_idx` (`user_id` ASC)
)
ENGINE = InnoDB;
            ";
        $this->execSqls($sqls);

    }

    public function down()
    {
        $this->dropTable('jz_complaint');
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
