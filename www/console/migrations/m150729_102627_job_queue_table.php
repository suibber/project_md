<?php

use yii\db\Schema;
use console\BaseMigration;

class m150729_102627_job_queue_table extends BaseMigration
{
    public function up()
    {

        $sqls = "
            create table jz_job_queue 
            (
                `id` INT NOT NULL AUTO_INCREMENT,
                `task_name` varchar(100) not null,
                `params` LONGBLOB,
                `retry_times` smallint not null default 2,
                `start_time` timestamp not null default CURRENT_TIMESTAMP,
                `priority` smallint not null default 2,
                `status` smallint not null default 0,
                `message` text,
                PRIMARY KEY (`id`),
                INDEX `idx_hot_job` (`status`)
            );
            ";
        return $this->execSqls($sqls);
    }

    public function down()
    {
        $this->dropTable('jz_job_queue');
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
