<?php

use yii\db\Migration;

/**
 * Handles adding new_fields to table `{{%competitor}}`.
 */
class m210216_070337_add_new_fields_column_to_competitor_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%competitor}}', 'market_share_percentage',  $this->string());
        $this->addColumn('{{%competitor}}', 'timely_delivery',  $this->string());
        $this->addColumn('{{%competitor}}', 'lead_time',  $this->string());
        $this->addColumn('{{%competitor}}', 'customer_relationship',  $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
