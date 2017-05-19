<?php

use yii\db\Schema;
use console\BaseMigration;

class m150629_103625_add_map_file_column extends BaseMigration
{
    public function up()
    {
        $sqls = "
            alter table jz_app_release_version add column h5_map_file varchar(1000);
            ";
        $this->execSqls($sqls);
    }

    public function down()
    {
        echo "m150629_103625_add_map_file_column cannot be reverted.\n";

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
