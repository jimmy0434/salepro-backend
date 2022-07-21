<?php

use yii\db\Migration;

/**
 * Class m211221_105427_Add_sector_to_industries_table
 */
class m211221_105427_Add_sector_to_industries_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      
        $this->addForeignKey(
            'industries2',
           
            '{{%industries}}',
            'portfolio_id',
            '{{%portfolio}}',
            'id',
            'CASCADE'
        );


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211221_105427_Add_sector_to_industries_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211221_105427_Add_sector_to_industries_table cannot be reverted.\n";

        return false;
    }
    */
}
