<?php

use yii\db\Migration;

/**
 * Class m210901_073655_change_fields_size_Steep_analisys_table
 */
class m210901_073655_change_fields_size_Steep_analisys_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%steep_analysis}}', 'control_measure', 'text');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210901_073655_change_fields_size_Steep_analisys_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210901_073655_change_fields_size_Steep_analisys_table cannot be reverted.\n";

        return false;
    }
    */
}
