<?php

use yii\db\Migration;

/**
 * Handles adding order to table `{{%statistic_number}}`.
 */
class m210111_070638_add_order_column_to_statistic_number_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%statistic_number}}', 'order', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%statistic_number}}', 'order');
    }
}
