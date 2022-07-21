<?php

use yii\db\Migration;

/**
 * Class m211221_114008_Add_relation_to_productindustries_table
 */
class m211221_114008_Add_relation_to_productindustries_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'industriesp1',
           
            '{{%product_industries}}',
            'product_id',
            '{{%product}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'industriesp2',
           
            '{{%product_industries}}',
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
        echo "m211221_114008_Add_relation_to_productindustries_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211221_114008_Add_relation_to_productindustries_table cannot be reverted.\n";

        return false;
    }
    */
}
