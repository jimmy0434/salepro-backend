<?php

use yii\db\Migration;

/**
 * Class m211221_083813_Add_relations_to_industries_table
 */
class m211221_083813_Add_relations_to_industries_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('{{%relations_industries}}');

 $this->addForeignKey(
            'industries_sector1',
           
            '{{%industries_sector}}',
            'industries_id',
            '{{%industries}}',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'industries_sector2',
           
            '{{%industries_sector}}',
            'sector_id',
            '{{%sector}}',
            'id',
            'CASCADE'
        );

     

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211221_083813_Add_relations_to_industries_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211221_083813_Add_relations_to_industries_table cannot be reverted.\n";

        return false;
    }
    */
}
