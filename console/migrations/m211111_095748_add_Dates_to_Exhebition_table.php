<?php

use yii\db\Migration;

/**
 * Class m211111_095748_add_Dates_to_Exhebition_table
 */
class m211111_095748_add_Dates_to_Exhebition_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%exhibition}}', 'lasteditionmonth',  $this->string());
        $this->addColumn('{{%exhibition}}', 'lasteditionyear',  $this->string());
        $this->addColumn('{{%exhibition}}', 'upcomingeditionmonth',  $this->string());
        $this->addColumn('{{%exhibition}}', 'upcomingeditionyear',  $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211111_095748_add_Dates_to_Exhebition_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211111_095748_add_Dates_to_Exhebition_table cannot be reverted.\n";

        return false;
    }
    */
}
