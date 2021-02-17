<?php

use yii\db\Migration;

/**
 * Handles dropping market_share_percentage from table `{{%competitor}}`.
 */
class m210216_093825_drop_market_share_percentage_column_from_competitor_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%competitor}}', 'market_share_percentage');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%competitor}}', 'market_share_percentage', $this->string());
    }
}
