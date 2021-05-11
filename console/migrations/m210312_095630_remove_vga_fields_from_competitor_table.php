<?php

use yii\db\Migration;

/**
 * Class m210312_095630_remove_vga_fields_from_competitor_table
 */
class m210312_095630_remove_vga_fields_from_competitor_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%competitor}}', 'timely_delivery');
        $this->dropColumn('{{%competitor}}', 'lead_time');
        $this->dropColumn('{{%competitor}}', 'customer_relationship');
        $this->addColumn('{{%competitor}}', 'hq_coordinates', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210312_095630_remove_vga_fields_from_competitor_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210312_095630_remove_vga_fields_from_competitor_table cannot be reverted.\n";

        return false;
    }
    */
}
