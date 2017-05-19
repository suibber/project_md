<?php

use yii\db\Schema;
use console\BaseMigration;

class m150527_133945_db_cache extends BaseMigration
{
    public function up()
    {
        $sqls = "
CREATE TABLE jz_cache_for_api (
    id char(128) NOT NULL PRIMARY KEY,
    expire int(11),
    data LONGBLOB
); 
CREATE TABLE jz_cache_for_frontend (
    id char(128) NOT NULL PRIMARY KEY,
    expire int(11),
    data LONGBLOB
); 
CREATE TABLE jz_cache_for_backend (
    id char(128) NOT NULL PRIMARY KEY,
    expire int(11),
    data LONGBLOB
); 
CREATE TABLE jz_cache_for_m (
    id char(128) NOT NULL PRIMARY KEY,
    expire int(11),
    data LONGBLOB
); 
            ";
        return $this->execSqls($sqls);
    }

    public function down()
    {
        $this->dropTable('jz_cache_for_api');
        $this->dropTable('jz_cache_for_backend');
        $this->dropTable('jz_cache_for_frontend');
        $this->dropTable('jz_cache_for_m');
        return true;
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
