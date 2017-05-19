<?php

use yii\db\Schema;
use console\BaseMigration;

class m150622_033519_add_new_attrs_to_company extends BaseMigration
{
    public function up()
    {


        $sqls = "alter table jz_company add column contact_email varchar(256) default null;
        alter table jz_company add column contact_phone varchar(128) default null;";
        
    }

    public function down()
    {
        echo "m150622_033519_add_new_attrs_to_company cannot be reverted.\n";

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
