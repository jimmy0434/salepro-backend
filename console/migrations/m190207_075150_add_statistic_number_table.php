<?php

use cnd\core\components\Migration;

/**
 * Class m190207_075150_add_statistic_number_table
 */
class m190207_075150_add_statistic_number_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('statistic_number', [
            'id' => $this->primaryKey(),
            'image' => $this->longText(),
            'label' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190207_075150_add_statistic_number_table cannot be reverted.\n";

        return false;
    }
}
