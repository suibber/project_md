<?php

use yii\db\Schema;
use console\BaseMigration;

class m150706_152700_spider_task_improvement extends BaseMigration
{
    public function up()
    {

        $sqls = "
        alter table jz_task_pool add release_date date ;
        alter table jz_task_pool add to_date date ;
            ";
        $this->execSqls($sqls);

    }

    public function down()
    {
        echo "m150706_152700_spider_task_improvement cannot be reverted.\n";

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
