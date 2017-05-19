<?php

use yii\db\Schema;
use console\BaseMigration;

class m150702_030724_add_api_version_column extends BaseMigration
{
    public function up()
    {
        $sqls = "
            alter table jz_app_release_version add api_version varchar(200);
            ";
        $this->execSqls($sqls);

    }

    public function down()
    {
        echo "m150702_030724_add_api_version_column cannot be reverted.\n";

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
