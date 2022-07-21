<?php

use yii\db\Migration;

/**
 * Class m220118_113016_add_collums_to_steep_analysis_table
 */
class m220118_113016_add_collums_to_steep_analysis_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%steep_analysis}}', 'building_block',  $this->string());
        $this->addColumn('{{%steep_analysis}}', 'product_line',  $this->string());
        $this->addColumn('{{%steep_analysis}}', 'georgraphical_area',  $this->string());
        $this->addColumn('{{%steep_analysis}}', 'sector',  $this->string());
        $this->addColumn('{{%steep_analysis}}', 'industry',  $this->string());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220118_113016_add_collums_to_steep_analysis_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220118_113016_add_collums_to_steep_analysis_table cannot be reverted.\n";

        return false;
    }
    */
}
