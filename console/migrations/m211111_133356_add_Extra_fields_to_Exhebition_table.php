<?php

use yii\db\Migration;

/**
 * Class m211111_133356_add_Extra_fields_to_Exhebition_table
 */
class m211111_133356_add_Extra_fields_to_Exhebition_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%exhibition}}', 'nbofvisitors',  $this->string());
        $this->addColumn('{{%exhibition}}', 'nbofexhebitors',  $this->string());
        $this->addColumn('{{%exhibition}}', 'nbofseminars',  $this->string());
        $this->addColumn('{{%exhibition}}', 'image',  $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211111_133356_add_Extra_fields_to_Exhebition_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211111_133356_add_Extra_fields_to_Exhebition_table cannot be reverted.\n";

        return false;
    }
    */
}
