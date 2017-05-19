<?php

use yii\db\Schema;
use console\BaseMigration;

class m150527_215311_resume_origin extends BaseMigration
{
    public function up()
    {

        $sqls = "
            alter table jz_resume add origin varchar(200) not null;
            ";
        return $this->execSqls($sqls);
    }

    public function down()
    {
        echo "m150527_215311_resume_origin cannot be reverted.\n";

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
