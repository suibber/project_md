<?php

use yii\db\Schema;
use console\BaseMigration;

class m150605_033206_user_access_token extends BaseMigration
{
    public function up()
    {
        $sqls = "
            alter table jz_user add access_token varchar(500);
            ";
        return $this->execSqls($sqls);
    }

    public function down()
    {
        echo "m150605_033206_user_access_token cannot be reverted.\n";

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
