<?php

use yii\db\Schema;
use console\BaseMigration;

class m150806_015703_contact_us_chartacter extends BaseMigration
{
    public function up()
    {
        $sqls = "
            alter table jz_contact_us         convert to character set utf8 collate utf8_unicode_ci;
            ";
        $this->execSqls($sqls);
    }

    public function down()
    {
        echo "m150806_015703_contact_us_chartacter cannot be reverted.\n";

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
