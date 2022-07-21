<?php

use yii\db\Migration;

/**
 * Class m211221_131610_Add_relation_to_tindustries_table
 */
class m211221_131610_Add_relation_to_tindustries_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'industriespw1',
           
            '{{%industries_brand}}',
            'brand_id',
            '{{%brand}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'industriespw2',
           
            '{{%industries_brand}}',
            'industries_id',
            '{{%industries}}',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'industriespwd1',
           
            '{{%industries_business_unit}}',
            'business_unit_id',
            '{{%business_unit}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'industriespwd2',
           
            '{{%industries_business_unit}}',
            'industries_id',
            '{{%industries}}',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211221_131610_Add_relation_to_tindustries_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211221_131610_Add_relation_to_tindustries_table cannot be reverted.\n";

        return false;
    }
    */
}
