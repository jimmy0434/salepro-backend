<?php

use yii\db\Migration;

/**
 * Class m211123_082705_add_Files_to_Exhebition_table
 */
class m211123_082705_add_Files_to_Exhebition_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%exhibition}}', 'file_id',  $this->integer());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211123_082705_add_Files_to_Exhebition_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211123_082705_add_Files_to_Exhebition_table cannot be reverted.\n";

        return false;
    }
    */
}
