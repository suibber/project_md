<?php

use yii\db\Schema;
use console\BaseMigration;

class m150606_093951_tidy_and_modify_database extends BaseMigration
{
    public function up()
    {
        $sqls = "
alter table jz_service_type add status smallint not null default 0;
            ";
        return $this->execSqls($sqls);
    }

    public function down()
    {
        echo "m150606_093951_tidy_and_modify_database cannot be reverted.\n";

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
