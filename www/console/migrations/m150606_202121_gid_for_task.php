<?php

use yii\db\Schema;
use console\BaseMigration;

class m150606_202121_gid_for_task extends BaseMigration
{
    public function up()
    {
        $sqls = "
            alter table jz_task add gid varchar(200) not null;
            create index idx_gid_of_task on jz_task (gid) USING BTREE;
            alter table jz_address change belong_to belong_to varchar(100) ;
            ";
        return $this->execSqls($sqls);
    }

    public function down()
    {
        echo "m150606_202121_gid_for_task cannot be reverted.\n";

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
