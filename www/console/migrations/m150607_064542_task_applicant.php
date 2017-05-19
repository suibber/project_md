<?php

use yii\db\Schema;
use console\BaseMigration;

class m150607_064542_task_applicant extends BaseMigration
{
    public function up()
    {
        $sqls = "
CREATE TABLE IF NOT EXISTS `jz_task_applicant` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `created_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '申请时间',
  `user_id` INT NOT NULL COMMENT '用户',
  `task_id` INT NOT NULL COMMENT '任务',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `applied_task_of_user` (`user_id` ASC, `task_id` ASC))
ENGINE = InnoDB; ";
        $this->execSqls($sqls);

    }

    public function down()
    {
        echo "m150607_064542_task_applicant cannot be reverted.\n";

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
