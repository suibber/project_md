<?php

use yii\db\Schema;
use console\BaseMigration;

class m150713_234814_set_company_name_nullable_in_spider_task extends BaseMigration
{
    public function up()
    {
        $sqls = "
        alter table jz_task_pool MODIFY company_name varchar(500) default null;
            ";
        $this->execSqls($sqls);

    }

    public function down()
    {
        echo "m150713_234814_set_company_name_nullable_in_spider_task cannot be reverted.\n";

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
