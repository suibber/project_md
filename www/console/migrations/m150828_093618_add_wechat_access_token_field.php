<?php

use yii\db\Schema;
use console\BaseMigration;

class m150828_093618_add_wechat_access_token_field extends BaseMigration
{
    public function up()
    {
        $sqls = "
            alter table jz_user add wechat_access_token varchar(500);
            alter table jz_user add app_access_token varchar(500);
            update jz_user set wechat_access_token=access_token ;
            update jz_user set app_access_token=access_token;
            create index idx_user_wechat_access_token on jz_user (wechat_access_token);
            create index idx_user_app_access_token on jz_user (app_access_token);
            alter table jz_user drop access_token;
            ";
        return $this->execSqls($sqls);
    }

    public function down()
    {
        echo "m150828_093618_add_wechat_access_token_field cannot be reverted.\n";

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
