<?php

use yii\db\Migration;

/**
 * Class m211221_070048_Edit_industries_table
 */
class m211221_070048_Edit_industries_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('industries');
        $this->dropTable('product_industries');
        $this->dropTable('industries_sector');

        $this->createTable('{{%industries}}',[
            'id' => $this->primaryKey(),
            'uid' => $this->string()->unique(),
            'portfolio_id' => $this->integer(),
        ]);
    
    $this->createTable('{{%product_industries}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'industries_id' => $this->integer(),
        ]);
    
    
        $this->createTable('{{%industries_sector}}', [
            'id' => $this->primaryKey(),
            'industries_id' => $this->integer(),
            'sector_id' => $this->integer(),
        ]);
    
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211221_070048_Edit_industries_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211221_070048_Edit_industries_table cannot be reverted.\n";

        return false;
    }
    */
}
