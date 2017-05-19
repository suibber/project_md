<?php

use yii\db\Schema;
use console\BaseMigration;

class m150801_085956_task_salary_and_payment extends BaseMigration
{
    public function up()
    {
        $sqls = "
        alter table jz_task_applicant add supposed_salary decimal(10,2);
        alter table jz_task_applicant add got_salary decimal(10,2);
        alter table jz_task_applicant add account_event_id int;

        CREATE TABLE `jz_account_event` (
          `id` INT NOT NULL AUTO_INCREMENT,
          `user_id` INT NOT NULL default 0,
          `value` decimal(10,2) not null,
          `created_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '变更时间',
          `balance` decimal(10, 2) not null,
          `type`  int not null,
          `related_id` int,
          PRIMARY KEY (`id`),
          INDEX `fk_jz_account_event_jz_user1_idx` (`user_id` ASC)
        ) ENGINE = InnoDB;

        CREATE TABLE `jz_withdraw_cash` (
          `id` INT NOT NULL AUTO_INCREMENT,
          `user_id` INT NOT NULL default 0,
          `value` decimal(10,2) not null,
          `withdraw_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '提现时间',
          `type` smallint not null COMMENT '打款方式',
          `payout_id` int COMMENT '打款明细',
          `status` smallint not null,
          `updated_time` TIMESTAMP NOT NULL,
          `note` text,
          PRIMARY KEY (`id`),
          INDEX `fk_jz_withdraw_cach_jz_user1_idx` (`user_id` ASC)
        ) ENGINE = InnoDB;

        CREATE TABLE `jz_payout` (
          `id` INT NOT NULL AUTO_INCREMENT,
          `gid` varchar(200) not null COMMENT '第三方流水号',
          `payout_time` TIMESTAMP NOT NULL,
          `value` decimal(10,2) not null,
          `type` smallint not null COMMENT '打款方式',
          `account_id` varchar(500) not null,
          `account_owner` varchar(100),
          `to_user_id` int not null,
          `status` smallint not null,
          `operator_id` int not null,
          `created_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '支出时间',
          `note` text,
          PRIMARY KEY (`id`),
          INDEX `fk_jz_payout_jz_user1_idx` (`to_user_id` ASC)
        ) ENGINE = InnoDB;
            ";

//        $this->execSqls($sqls);
    }

    public function down()
    {
        echo "m150801_085956_task_salary_and_payment cannot be reverted.\n";

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
