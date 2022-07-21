<?php

use yii\db\Migration;

/**
 * Class m211221_125206_Add_barand_to_industries_table
 */
class m211221_125206_Add_barand_to_industries_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%industries_brand}}', [
            'id' => $this->primaryKey(),
            'industries_id' => $this->integer(),
            'brand_id' => $this->integer(),
            'created_at'=>
            $this->integer()->defaultValue(null),
            'updated_at'=>
            $this->integer()->defaultValue(null)

        ]);
    
    
        $this->createTable('{{%industries_business_unit}}', [
            'id' => $this->primaryKey(),
            'industries_id' => $this->integer(),
            'business_unit_id' => $this->integer(),
            'created_at'=>
            $this->integer()->defaultValue(null),
            'updated_at'=>
            $this->integer()->defaultValue(null)

        ]);
    

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211221_125206_Add_barand_to_industries_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211221_125206_Add_barand_to_industries_table cannot be reverted.\n";

        return false;
    }
    */
}
