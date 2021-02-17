<?php

use yii\db\Migration;

/**
 * Handles adding weight_and_score to table `{{%data_list}}`.
 */
class m210217_082754_add_weight_and_score_column_to_data_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%data_list}}', 'weight',  $this->string());
        $this->addColumn('{{%data_list}}', 'score',  $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
