<?php

use yii\db\Schema;
use console\BaseMigration;

class m150705_071505_task_pool_of_spider extends BaseMigration
{
    public function up()
    {
        $sqls = "
DROP TABLE IF EXISTS `jz_task_pool_white_list`;
CREATE TABLE IF NOT EXISTS `jz_task_pool_white_list` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `origin` VARCHAR(200) NOT NULL,
  `attr` VARCHAR(200) NOT NULL,
  `value` VARCHAR(200) NOT NULL,
  `examined_time` TIMESTAMP NOT NULL DEFAULT current_timestamp,
  `slug` VARCHAR(100) NULL,
  `examined_by` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `origin_attr_value_UNIQUE` (`origin` ASC, `attr` ASC, `value` ASC))
ENGINE = InnoDB;

    alter table jz_task_pool add created_time timestamp not null default current_timestamp;
            ";
        $this->execSqls($sqls);

    }

    public function down()
    {
        $this->dropTable('jz_task_pool_white_list');
    }

}
