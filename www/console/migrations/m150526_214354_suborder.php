<?php

use yii\db\Schema;
use yii\db\Migration;

use console\BaseMigration;

class m150526_214354_suborder extends BaseMigration
{
    public function up()
    {
        $sqls = "
CREATE TABLE IF NOT EXISTS `jz_suborder` (
  `order_id` BIGINT NOT NULL COMMENT '服务地址',
  `address_id` INT NOT NULL COMMENT '地址',
  `date` DATE NOT NULL,
  `from_time` TIME NOT NULL COMMENT '开始时间',
  `to_time` TIME NOT NULL COMMENT '结束时间',
  `quantity` INT NOT NULL COMMENT '需人数',
  `got_qunatity` INT NOT NULL DEFAULT 0 COMMENT '已有人数',
  `modified_by` INT NOT NULL COMMENT '修改人',
  `pm_id` INT NOT NULL DEFAULT 0 COMMENT '项目经理',
  PRIMARY KEY (`order_id`, `address_id`),
  INDEX `fk_jz_offline_orders_has_jz_addresses_jz_addresses1_idx` (`address_id` ASC),
  INDEX `fk_jz_offline_orders_has_jz_addresses_jz_offline_orders1_idx` (`order_id` ASC),
  INDEX `fk_jz_orders_has_schedules_jz_user1_idx` (`modified_by` ASC),
  INDEX `fk_jz_suborder_jz_user1_idx` (`pm_id` ASC)
) ENGINE = InnoDB ;

CREATE TABLE IF NOT EXISTS `jz_tinyorder` (
  `id` INT NOT NULL,
  `order_id` BIGINT NOT NULL COMMENT '订单号',
  `address_id` INT NOT NULL COMMENT '地址',
  `user_id` INT NOT NULL COMMENT '用户',
  `added_by` INT NOT NULL COMMENT '添加人',
  `status` SMALLINT NOT NULL DEFAULT 0 COMMENT '状态',
  PRIMARY KEY (`id`),
  INDEX `fk_jz_tinyorder_jz_suborder1_idx` (`order_id` ASC, `address_id` ASC),
  INDEX `fk_jz_tinyorder_jz_user1_idx` (`user_id` ASC),
  INDEX `fk_jz_tinyorder_jz_user2_idx` (`added_by` ASC)
) ENGINE = InnoDB ";
        $this->execSqls($sqls);
    }

    public function down()
    {
        $this->dropTable('jz_tinyorder');
        $this->dropTable('jz_suborder');
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
