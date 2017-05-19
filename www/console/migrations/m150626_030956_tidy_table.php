<?php

use yii\db\Schema;
use yii\db\Migration;

class m150626_030956_tidy_table extends Migration
{
    public function up()
    {
        $this->dropTable('jz_offline_order');
        $this->dropTable('jz_offline_orders_has_addresses');
        $this->dropTable('jz_online_order');
        $this->dropTable('jz_suborder');
        $this->dropTable('jz_tinyorder');
    }

    public function down()
    {
        echo "m150626_030956_tidy_table cannot be reverted.\n";

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
