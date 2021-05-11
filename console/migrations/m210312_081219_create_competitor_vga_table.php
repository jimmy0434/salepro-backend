<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%competitor_vga}}`.
 */
class m210312_081219_create_competitor_vga_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%competitor_vga}}', [
            'id' => $this->primaryKey(),
            'competitor_id' => $this->integer(),
            'country' => $this->string(),
            'product_type' => $this->string(),
            'quality' => $this->string(),
            'brand_equity' => $this->string(),
            'problem_solving_response' => $this->string(),
            'timely_delivery' => $this->string(),
            'lead_time' => $this->string(),
            'customer_relationship' => $this->string(),
            'payment_facilities' => $this->string(),
            'price' => $this->string(),
            'market_share_percentage' => $this->string(),

        ]);
        $this->addForeignKey(
            'competitor_id_fk',
           
            '{{%competitor_Vga}}',
            'competitor_id',
            '{{%competitor}}',
            'id',
            'CASCADE'
        );
    
 
}


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%competitor_vga}}');
    }
}
