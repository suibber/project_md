<?php

use yii\db\Schema;
use console\BaseMigration;

class m150721_072613_tidy_company_columns extends BaseMigration
{
    public function up()
    {
        $sqls = "
            alter table jz_company drop column introduction;
            alter table jz_company drop column license_id;
            alter table jz_company drop column license_img;
            ";
        $this->execSqls($sqls);
    }

    public function down()
    {
        echo "m150721_072613_tidy_company_columns cannot be reverted.\n";

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
