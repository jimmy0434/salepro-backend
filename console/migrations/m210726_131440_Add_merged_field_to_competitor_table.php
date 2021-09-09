<?php

use yii\db\Migration;

/**
 * Class m210726_131440_Add_merged_field_to_competitor_table
 */
class m210726_131440_Add_merged_field_to_competitor_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%competitor}}', 'merged', 'enum("enabled","disabled") DEFAULT "enabled"');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210726_131440_Add_merged_field_to_competitor_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210726_131440_Add_merged_field_to_competitor_table cannot be reverted.\n";

        return false;
    }
    */
}
