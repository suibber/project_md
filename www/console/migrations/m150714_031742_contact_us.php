<?php

use yii\db\Schema;
use console\BaseMigration;

class m150714_031742_contact_us extends BaseMigration
{
    public function up()
    {
        $sqls = "
drop table if exists `jz_contact_us`;
CREATE TABLE IF NOT EXISTS `jz_contact_us` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(100),
  `content` TEXT NULL,
  `created_time` TIMESTAMP NULL DEFAULT current_timestamp,
  `phonenum` varchar(100) not NULL ,
  `status` SMALLINT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
)
ENGINE = InnoDB;
            ";
        $this->execSqls($sqls);

    }

    public function down()
    {
        echo "m150714_031742_contact_us cannot be reverted.\n";

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
