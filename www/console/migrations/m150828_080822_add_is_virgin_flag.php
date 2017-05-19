<?php

use yii\db\Schema;
use console\BaseMigration;

class m150828_080822_add_is_virgin_flag extends BaseMigration
{
    public function up()
    {
        $sqls = "
            alter table jz_user add is_virgin boolean not null default 1;
            ";
        return $this->execSqls($sqls);
    }

    public function down()
    {
        echo "m150828_080822_add_is_virgin_flag cannot be reverted.\n";

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
