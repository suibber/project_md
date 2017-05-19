<?php

use yii\db\Schema;
use console\BaseMigration;

class m150829_034357_add_city_id_to_resume extends BaseMigration
{
    public function up()
    {
        $sqls = "
            alter table jz_resume add city_id int ;
            ";
        return $this->execSqls($sqls);
    }

    public function down()
    {
        echo "m150829_034357_add_city_id_to_resume cannot be reverted.\n";

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
