<?php

use yii\db\Schema;
use console\BaseMigration;

class m150617_101651_add_is_active_to_device_table extends BaseMigration
{
    public function up()
    {
        $sqls = "
            alter table jz_device add is_active boolean not null default true;
            ";
        $this->execSqls($sqls);
    }

    public function down()
    {
        echo "m150617_101651_add_is_active_to_device_table cannot be reverted.\n";

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
