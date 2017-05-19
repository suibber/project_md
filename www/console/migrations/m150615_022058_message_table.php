<?php

use yii\db\Schema;
use console\BaseMigration;

class m150615_022058_message_table extends BaseMigration
{
    public function up()
    {
        $sqls = "
CREATE TABLE IF NOT EXISTS `jz_sys_message` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL default 0,
  `read_flag` TINYINT(1) NOT NULL DEFAULT false,
  `message` TEXT NOT NULL,
  `title` VARCHAR(100) NOT NULL,
  `created_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `has_sent` TINYINT(1) NOT NULL DEFAULT false COMMENT '已发送',
  PRIMARY KEY (`id`),
  INDEX `fk_jz_message_jz_user1_idx` (`user_id` ASC)
) ENGINE = InnoDB;
";
        $this->execSqls($sqls);
    }

    public function down()
    {
        $this->dropTable('jz_sys_message');
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
