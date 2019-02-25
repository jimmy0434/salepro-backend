<?php

use cnd\core\components\Migration;

/**
 * Class m190225_124605_add_logistic_table
 */
class m190225_124605_add_logistic_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('logistic_category', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'image' => $this->longText(),
            'position' => $this->integer(),
        ]);

        $this->createTable('logistic', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'image' => $this->longText(),
            'category_id' => $this->integer(),
            'file_id' => $this->integer(),
            'position' => $this->integer(),
        ]);

        $this->safeOperation(function () {
            $this->createIndexForeignKey('logistic.category_id', 'logistic_category.id');
            $this->createIndexForeignKey('logistic.file_id', 'file.id');
        });
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190225_124605_add_logistic_table cannot be reverted.\n";

        return false;
    }
}
