<?php

use yii\db\Schema;
use yii\db\Migration;
use common\models\Resume;

class m150814_025732_assign_phonenum_of_resume extends Migration
{
    public function up()
    {
        $rs = Resume::find()->with('user')->where("phonenum=''")->all();
        foreach ($rs as $r){
            if ($r->user){
                $r->phonenum = $r->user->username;
                $r->save();
            }
        }
    }

    public function down()
    {
        echo "m150814_025732_assign_phonenum_of_resume cannot be reverted.\n";

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
