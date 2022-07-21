<?php

use yii\db\Migration;

/**
 * Class m211221_100535_Add_created_to_industries_table
 */
class m211221_100535_Add_created_to_industries_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%industries}}', 'created_at',  $this->integer()->defaultValue(null));
        $this->addColumn('{{%industries}}', 'updated_at',  $this->integer()->defaultValue(null));

        $this->addColumn('{{%product_industries}}', 'created_at',  $this->integer()->defaultValue(null));
        $this->addColumn('{{%product_industries}}', 'updated_at',  $this->integer()->defaultValue(null));

        $this->addColumn('{{%industries_sector}}', 'created_at',  $this->integer()->defaultValue(null));
        $this->addColumn('{{%industries_sector}}', 'updated_at',  $this->integer()->defaultValue(null));

        
       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211221_100535_Add_created_to_industries_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211221_100535_Add_created_to_industries_table cannot be reverted.\n";

        return false;
    }
    */
}
