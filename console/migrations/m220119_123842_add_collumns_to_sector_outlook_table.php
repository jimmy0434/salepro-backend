<?php

use yii\db\Migration;

/**
 * Class m220119_123842_add_collumns_to_sector_outlook_table
 */
class m220119_123842_add_collumns_to_sector_outlook_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
  
   
        $this->addColumn('{{%sector_outlook}}', 'building_block',  $this->string());
        $this->addColumn('{{%sector_outlook}}', 'product_line',  $this->string());
        $this->addColumn('{{%sector_outlook}}', 'geographical_area',  $this->string());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220119_123842_add_collumns_to_sector_outlook_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220119_123842_add_collumns_to_sector_outlook_table cannot be reverted.\n";

        return false;
    }
    */
}
