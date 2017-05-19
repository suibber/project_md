<?php

use yii\db\Schema;
use console\BaseMigration;

class m150807_073629_spider_task_indx extends BaseMigration
{
    public function up()
    {
        $sqls = "
        create index idx_spider_task_phonenum on jz_task_pool (phonenum);
        alter table jz_task_pool add task_id int;
            ";
        $this->execSqls($sqls);

    }

    public function down()
    {
        echo "m150807_073629_spider_task_indx cannot be reverted.\n";

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
