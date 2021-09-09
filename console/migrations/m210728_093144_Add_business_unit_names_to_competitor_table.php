<?php

use yii\db\Migration;

/**
 * Class m210728_093144_Add_business_unit_names_to_competitor_table
 */
class m210728_093144_Add_business_unit_names_to_competitor_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%competitor}}', 'business_unit_names', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210728_093144_Add_business_unit_names_to_competitor_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210728_093144_Add_business_unit_names_to_competitor_table cannot be reverted.\n";

        return false;
    }
    */
}
