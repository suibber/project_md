<?php

use yii\db\Schema;
use console\BaseMigration;

class m150702_180117_add_features_to_app_release_table extends BaseMigration
{
    public function up()
    {
        $sqls = "
            alter table jz_app_release_version add features text default null;
            ";
        $this->execSqls($sqls);

    }

    public function down()
    {
        echo "m150702_180117_add_features_to_app_release_table cannot be reverted.\n";

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
