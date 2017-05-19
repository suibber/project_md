<?php

use yii\db\Schema;
use yii\db\Migration;
use console\BaseMigration;

class m150623_085430_add_enabled_flag_to_city extends BaseMigration
{
    public function up()
    {
        $sqls = "
            alter table jz_district add column disabled bool not null default true;
            update jz_district set disabled = false where id = 3 or parent_id = 3;
            ";
        $this->execSqls($sqls);

    }

    public function down()
    {
        echo "m150623_085430_add_enabled_flag_to_city cannot be reverted.\n";

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
