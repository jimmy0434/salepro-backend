<?php

use cnd\core\components\Migration;

/**
 * Class m190206_133218_add_data_list_table_and_job_title_to_salesman
 */
class m190206_133218_add_data_list_table_and_job_title_to_salesman extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%salesman}}', 'job_title', $this->string());

        $this->createTable('data_list', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'parent_id' => $this->integer(),
            'type' => $this->tinyInteger(),
        ]);

        $this->safeOperation(function () {
            $this->createIndexForeignKey('data_list.parent_id', 'data_list.id');
        });
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190206_133218_add_data_list_table_and_job_title_to_salesman cannot be reverted.\n";

        return false;
    }
}
