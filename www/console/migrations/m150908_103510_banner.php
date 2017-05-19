<?php

use yii\db\Schema;
use console\BaseMigration;

class m150908_103510_banner extends BaseMigration
{
    public function up()
    {
        $sqls = "
            alter table jz_config_banner add task_id int(11) default null comment '任务id';
            ";
        return $this->execSqls($sqls);
    }

    public function down()
    {
        echo "m150908_103510_banner cannot be reverted.\n";

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
