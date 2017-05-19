<?php

use yii\db\Schema;
use console\BaseMigration;

class m150817_071751_support_extensions extends BaseMigration
{
    public function up()
    {
        $sqls = "
            alter table jz_task add time_book_opened bool not null default false;
            ";
        return $this->execSqls($sqls);

    }

    public function down()
    {
        echo "m150817_071751_support_extensions cannot be reverted.\n";

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
