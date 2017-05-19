<?php

use yii\db\Schema;
use console\BaseMigration;

class m150915_071603_book_schedule extends BaseMigration
{
    public function up()
    {
        $sqls = "
alter table `ext_time_book_schedule` add `out_work_on` smallint(6) NOT NULL DEFAULT '0';
alter table `ext_time_book_schedule` add `out_work_off` smallint(6) NOT NULL DEFAULT '0';
            ";
        return $this->execSqls($sqls);
    }

    public function down()
    {
        echo "m150915_071603_book_schedule cannot be reverted.\n";

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
