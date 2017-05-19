<?php

use yii\db\Schema;
use console\BaseMigration;

class m150725_072802_corp_cache_table extends BaseMigration
{
    public function up()
    {
        $sqls = "
CREATE TABLE jz_cache_for_corp (
    id char(128) NOT NULL PRIMARY KEY,
    expire int(11),
    data LONGBLOB
); 
            ";
        return $this->execSqls($sqls);

    }

    public function down()
    {
        echo "m150725_072802_corp_cache_table cannot be reverted.\n";

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
