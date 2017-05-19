<?php

use yii\db\Schema;
use console\BaseMigration;

class m150827_093605_user_historical_locations extends BaseMigration
{
    public function up()
    {
        $sqls = "
CREATE TABLE IF NOT EXISTS `jz_user_historical_location` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `lng` FLOAT NULL,
  `lat` FLOAT NULL,
  `created_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` INT NOT NULL,
  `city_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_jz_user_historical_location_jz_user1_idx` (`user_id` ASC)
  ) ENGINE = InnoDB 
            ";
        return $this->execSqls($sqls);


    }

    public function down()
    {
        echo "m150827_093605_user_historical_locations cannot be reverted.\n";

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
