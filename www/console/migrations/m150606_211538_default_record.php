<?php

use yii\db\Schema;
use console\BaseMigration;

class m150606_211538_default_record extends BaseMigration
{
    public function up()
    {
        $sqls = "
insert into jz_address (
    id, province, city, district, address, lat, lng, user_id, belong_to 
) values (
    '0', '北京市', '北京市', '朝阳区', '云岭路8号', '45.18923000', '45.12323000', '1', NULL ) ;

insert into jz_user (
    id, username, password_hash, password_reset_token, email,
    auth_key, status, created_time, updated_time, name,
    access_token, is_staff 
) values (
    '0', '10000000000',
    '', NULL, NULL, NULL, '0',
    '2015-05-28 05:52:12',
    '2015-06-07 05:37:58', NULL, NULL, '0'
);
            ";
        $this->execSqls($sqls);

    }

    public function down()
    {
        echo "m150606_211538_default_record cannot be reverted.\n";

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
