<?php

use yii\db\Schema;
use console\BaseMigration;

class m150607_055050_task_collection extends BaseMigration
{
    public function up()
    {
        $sqls = "
CREATE TABLE IF NOT EXISTS `jz_task_collection` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `created_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` INT NOT NULL COMMENT '收藏人',
  `task_id` INT NOT NULL COMMENT '任务',
  PRIMARY KEY (`id`),
  INDEX `fk_jz_task_collection_jz_user1_idx` (`user_id` ASC)
)
ENGINE = InnoDB";
        $this->execSqls($sqls);
    }

    public function down()
    {
        echo "m150607_055050_task_collection cannot be reverted.\n";

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
