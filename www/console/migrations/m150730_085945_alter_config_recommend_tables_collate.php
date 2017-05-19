<?php

use yii\db\Schema;
use yii\db\Migration;

class m150730_085945_alter_config_recommend_tables_collate extends Migration
{
    public function up()
    {
                $sqls = "ALTER TABLE jz_config_recommend CONVERT TO CHARACTER SET utf8 collate utf8_unicode_ci";
    }

    public function down()
    {
        echo "m150730_085945_alter_config_recommend_tables_collate cannot be reverted.\n";

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
