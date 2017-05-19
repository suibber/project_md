<?php

use yii\db\Schema;
use console\BaseMigration;

class m150701_085023_add_task_labels extends BaseMigration
{
    public function up()
    {
        $sqls = "
            alter table jz_task add labels_str text;
            ";
        $this->execSqls($sqls);

    }

    public function down()
    {
        echo "m150701_085023_add_task_labels cannot be reverted.\n";

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
