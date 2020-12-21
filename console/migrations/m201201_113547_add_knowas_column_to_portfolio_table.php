<?php

use yii\db\Migration;

/**
 * Handles adding knowas to table `{{%portfolio}}`.
 */
class m201201_113547_add_knowas_column_to_portfolio_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%portfolio}}', 'image_outside', $this->Text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%portfolio}}', 'image_outside');
    }
}
