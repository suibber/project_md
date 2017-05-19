<?php

namespace console;
use yii\db\Migration;


class BaseMigration extends Migration
{

    public function execSqls($sqls)
    {
        $transaction = $this->db->beginTransaction();
        try {
            $sqllist = explode(';', $sqls);
            foreach ($sqllist as $sql){
                if (strlen(trim($sql))>0){
                    $this->db->createCommand($sql)->execute();
                }
            }

            $transaction->commit();
            return true;
        } catch (Exception $e) {
            $transaction->rollBack();
            echo $e;
            return false;
        }
    }

}
