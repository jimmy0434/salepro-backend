<?php

use cnd\core\components\Migration;

/**
 * Class m181204_134422_add_log_change_table
 */
class m181204_134422_add_log_change_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('log_change', [
            'id' => $this->primaryKey(),
            'log_id' => $this->integer(),
            'name' => $this->string(),
            'from' => $this->text(),
            'to' => $this->text(),
        ]);

        $this->dropColumn('log','data');

        $this->addRelations(function(){
            $this->createIndexForeignKey('log_change.log_id', 'log.id');
        });
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181204_134422_add_log_change_table cannot be reverted.\n";

        return false;
    }
}
