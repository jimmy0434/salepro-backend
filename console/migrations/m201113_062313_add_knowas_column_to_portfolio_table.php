<?php

use yii\db\Migration;

/**
 * Handles adding knowas to table `{{%portfolio}}`.
 */
class m201113_062313_add_knowas_column_to_portfolio_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%portfolio}}', 'knowas', $this->Text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%portfolio}}', 'knowas');
    }
}
