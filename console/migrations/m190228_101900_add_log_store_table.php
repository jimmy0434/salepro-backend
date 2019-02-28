<?php

use cnd\core\components\Migration;

/**
 * Class m190228_101900_add_log_store_table
 */
class m190228_101900_add_log_store_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('log_store', [
            'id' => $this->primaryKey(),
            'app' => $this->string(50),
            'user_id' => $this->integer(),
            'message' => $this->text(),
            'date' => $this->dateTime(),
            'level' => $this->string(20),
        ]);

        $this->createTable('log_store_change', [
            'id' => $this->primaryKey(),
            'log_store_id' => $this->integer(),
            'name' => $this->string(),
            'from' => $this->text(),
            'to' => $this->text(),
        ]);

        $this->addRelations(function(){
            $this->createIndexForeignKey('log_store.user_id', 'base_user.id');
            $this->createIndexForeignKey('log_store_change.log_store_id', 'log_store.id');
        });
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190228_101900_add_log_store_table cannot be reverted.\n";

        return false;
    }
}
