<?php

use yii\db\Schema;
use console\BaseMigration;

class m150817_082809_ext_time_book extends BaseMigration
{
    public function up()
    {

        $sqls = "

CREATE TABLE IF NOT EXISTS `ext_time_book_schedule` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` VARCHAR(200) NULL,
  `task_id` VARCHAR(200) NULL,
  `from_datetime` TIMESTAMP NOT NULL,
  `to_datetime` TIMESTAMP NOT NULL,
  `allowable_distance_offset` INT NOT NULL DEFAULT 500,
  `lat` double,
  `lng` double,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `ext_time_book_record` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `lat` double not null,
  `lng` double not null,
  `event_type` SMALLINT NULL,
  `created_time` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` VARCHAR(200) NULL,
  `schedule_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_ext_time_book_record_ext_time_book_schedule1_idx` (`schedule_id` ASC)
) ENGINE = InnoDB ;
alter table ext_time_book_record add owner_id varchar(200) not null;
alter table ext_time_book_schedule add owner_id varchar(200) not null;

alter table ext_time_book_schedule add on_late smallint not null default 0;
alter table ext_time_book_schedule add off_early smallint not null default 0;
alter table ext_time_book_schedule add out_work smallint not null default 0;
alter table ext_time_book_schedule add note varchar(2000) default null;
alter table ext_time_book_schedule add address varchar(500);
alter table ext_time_book_schedule add task_title varchar(500);
alter table ext_time_book_schedule add date date ;
            ";
        $this->execSqls($sqls);
    }

    public function down()
    {
        $this->dropTable('ext_time_book_record');
        $this->dropTable('ext_time_book_schedule');
        return 1;
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
