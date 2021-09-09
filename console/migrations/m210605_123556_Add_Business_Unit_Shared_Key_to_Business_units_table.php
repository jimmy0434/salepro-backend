<?php

use yii\db\Migration;

/**
 * Class m210605_123556_Add_Business_Unit_Shared_Key_to_Business_units_table
 */
class m210605_123556_Add_Business_Unit_Shared_Key_to_Business_units_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%business_unit}}', 'business_unit_shared_key',  $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210605_123556_Add_Business_Unit_Shared_Key_to_Business_units_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210605_123556_Add_Business_Unit_Shared_Key_to_Business_units_table cannot be reverted.\n";

        return false;
    }
    */
}
