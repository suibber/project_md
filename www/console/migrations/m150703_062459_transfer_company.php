<?php

use yii\db\Schema;
use console\BaseMigration;

class m150703_062459_transfer_company extends BaseMigration
{
    public function up()
    {
        $sqls = "
            insert into jz_company (name, introduction) 
                select DISTINCT (company_name) company_name, company_introduction from jz_task;
                update jz_task set company_id = (select id from jz_company where jz_company.name=jz_task.company_name limit 1) where 1=1;
                
            ";
        $this->execSqls($sqls);

    }

    public function down()
    {
        $sqls = "delete from jz_company;";
        $this->execSqls($sqls);
        return true;
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
