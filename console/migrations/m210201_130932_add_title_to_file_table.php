<?php

use yii\db\Migration;

/**
 * Class m210201_130932_add_title_to_file_table
 */
class m210201_130932_add_title_to_file_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%file}}', 'name',  $this->string());
      
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210201_130932_add_title_to_file_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210201_130932_add_title_to_file_table cannot be reverted.\n";

        return false;
    }
    */
}
