<?php

use cnd\core\components\Migration;

/**
 * Class m181204_111810_add_log_table
 */
class m181204_111810_add_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('log', [
            'id' => $this->primaryKey(),
            'app' => $this->string(50),
            'user_id' => $this->integer(),
            'message' => $this->text(),
            'data' => $this->longText(),
            'date' => $this->dateTime(),
            'level' => $this->string(20),
        ]);

        $this->addRelations(function(){
            $this->createIndexForeignKey('log.user_id', 'user.id');
        });
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181204_111810_add_log_table cannot be reverted.\n";

        return false;
    }
}
