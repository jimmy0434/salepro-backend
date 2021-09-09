<?php

use yii\db\Migration;

/**
 * Class m210601_084854_adding_product_line_to_VGA_and_five_forces_table
 */
class m210601_084854_adding_product_line_to_VGA_and_five_forces_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    { 
        
        $this->addColumn('{{%competitor_vga}}', 'product_line',  $this->string());
        $this->addColumn('{{%five_forces}}', 'product_line',  $this->string());
   

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210601_084854_adding_product_line_to_VGA_and_five_forces_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210601_084854_adding_product_line_to_VGA_and_five_forces_table cannot be reverted.\n";

        return false;
    }
    */
}
