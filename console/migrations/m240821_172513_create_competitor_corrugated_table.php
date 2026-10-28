<?php

use cnd\core\components\Migration;

/**
 * Handles the creation of table `{{%competitor_corrugated}}`.
 */
class m240821_172513_create_competitor_corrugated_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       
        $this->createTable('{{%competitor_corrugated}}', [
            'id' => $this->primaryKey(),
            'competitor_id' => $this->integer(),
            'product_type' => $this->string(),
            'sector_id' => $this->integer(),
            'quantity_sold' => $this->string(),
            'quantity_unit' => $this->string(),

            'material' => $this->string(),
            'flute_type' => $this->string(),
            'thickness' => $this->string(),
            'strength_test' => $this->string(),
            'dimensions' => $this->string(),
            'Weight' => $this->boolean(),
            'Printing' => $this->boolean(),
            'coating' => $this->string(),
            'surface_finish' => $this->string(),
            'color' => $this->string(),
            'volume' => $this->string(),

            'business_terms' => $this->string(),
            'incoterms' => $this->string(),
            'payment' => $this->string(),
            'price' => $this->string(),
            'currency' => $this->string(),
        ]);

        $this->createTable('{{%competitor_corrugated_customer}}', [
            'id' => $this->primaryKey(),
            'competitor_id' => $this->integer(),
            'competitor_corrugated_id' => $this->integer(),
            'name' => $this->string(),
            'country' => $this->string(),
            'share_percentage' => $this->string(),
        ]);
        $this->safeOperation(function () {
   
            $this->createIndexForeignKey('competitor_corrugated.competitor_id', 'competitor.id');
            $this->createIndexForeignKey('competitor_corrugated.sector_id', 'sector.id');
            $this->createIndexForeignKey('competitor_corrugated_customer.competitor_id', 'competitor.id');
            $this->createIndexForeignKey('competitor_corrugated_customer.competitor_corrugated_id', 'competitor_corrugated_customer.id');


        });

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%competitor_corrugated}}');
        $this->dropTable('{{%competitor_corrugated_customer}}');
    }
}
