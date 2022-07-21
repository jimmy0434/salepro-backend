<?php

use yii\db\Migration;

/**
 * Class m220119_093419_add_geographical_area_to_steep_analysis_table
 */
class m220119_093419_add_geographical_area_to_steep_analysis_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%five_forces}}', 'geographical_area',  $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220119_093419_add_geographical_area_to_steep_analysis_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220119_093419_add_geographical_area_to_steep_analysis_table cannot be reverted.\n";

        return false;
    }
    */
}
