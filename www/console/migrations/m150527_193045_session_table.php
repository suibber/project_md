<?php

use yii\db\Schema;
use console\BaseMigration;

class m150527_193045_session_table extends BaseMigration
{
    public function up()
    {
        $sqls = "
CREATE TABLE jz_session
(
    id CHAR(40) NOT NULL PRIMARY KEY,
    expire INTEGER,
    data LONGBLOB
) ";
        return $this->execSqls($sqls);
    }

    public function down()
    {
        return $this->dropTable('jz_session');
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
