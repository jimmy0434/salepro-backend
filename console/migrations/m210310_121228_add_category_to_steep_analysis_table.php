<?php

use yii\db\Migration;

/**
 * Class m210310_121228_add_category_to_steep_analysis_table
 */
class m210310_121228_add_category_to_steep_analysis_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%steep_analysis}}', 'category',  $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210310_121228_add_category_to_steep_analysis_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210310_121228_add_category_to_steep_analysis_table cannot be reverted.\n";

        return false;
    }
    */
}
