<?php

use yii\db\Schema;
use console\BaseMigration;

class m150907_085718_company_origin extends BaseMigration
{
    public function up()
    {
        $sqls = "
            alter table jz_company add origin TINYINT(4) default 0 comment '渠道来源';
            ";
        return $this->execSqls($sqls);
    }

    public function down()
    {
        echo "m150907_085718_company_origin cannot be reverted.\n";

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
