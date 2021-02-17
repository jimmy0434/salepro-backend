<?php

use yii\db\Migration;

/**
 * Handles adding market_share_percentage to table `{{%competitor}}`.
 */
class m210216_093938_add_market_share_percentage_column_to_competitor_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%competitor_flexible}}', 'market_share_percentage',  $this->string());
        $this->addColumn('{{%competitor_masterbatch}}', 'market_share_percentage',  $this->string());
        $this->addColumn('{{%competitor_packaging}}', 'market_share_percentage',  $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
