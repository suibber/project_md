<?php

use yii\db\Schema;
use console\BaseMigration;

class m150713_111256_change_tables_unicode_weichat extends BaseMigration
{
    public function up()
    {
        $sqls = "
       alter table jz_weichat_push_set_template_push_item         convert to character set utf8 collate utf8_unicode_ci;
            ";
        $this->execSqls($sqls);
    }

    public function down()
    {
        echo "m150704_103032_change_tables_unicode cannot be reverted.\n";

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