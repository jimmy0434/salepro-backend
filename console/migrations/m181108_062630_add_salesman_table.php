<?php

use cnd\core\components\Migration;

/**
 * Class m181108_062630_add_salesman_table
 */
class m181108_062630_add_salesman_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('salesman', [
            'id' => 'INT(11) NOT NULL primary key',
            'name' => $this->string(),
            'image' => $this->mediumText(),
            'mac_address' => $this->string(),
        ]);

        $this->addRelations(function(){
            $this->createIndexForeignKey('salesman.id', 'base_user.id');
        });
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181108_062630_add_salesman_table cannot be reverted.\n";

        return false;
    }
}
