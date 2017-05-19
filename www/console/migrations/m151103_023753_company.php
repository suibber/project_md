<?php

use yii\db\Schema;
use console\BaseMigration;

class m151103_023753_company extends BaseMigration
{
    public function up()
    {
        $sqls = "
alter table `jz_company` add `city_id` int(10) DEFAULT 3 NOT NULL;
            ";
        return $this->execSqls($sqls);
    }

    public function down()
    {
        echo "m151103_023753_company cannot be reverted.\n";

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
