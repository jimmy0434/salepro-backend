<?php

use yii\db\Migration;

/**
 * Class m211130_064857_add_Organizer_to_Exhibition_table
 */
class m211130_064857_add_Organizer_to_Exhibition_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%exhibition}}', 'organizer',  $this->string());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211130_064857_add_Organizer_to_Exhibition_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211130_064857_add_Organizer_to_Exhibition_table cannot be reverted.\n";

        return false;
    }
    */
}
