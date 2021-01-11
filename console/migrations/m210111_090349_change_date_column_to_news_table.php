<?php

use yii\db\Migration;

/**
 * Class m210111_090349_change_date_column_to_news_table
 */
class m210111_090349_change_date_column_to_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%news}}', 'date',  $this->string());
       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210111_090349_change_date_column_to_news_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210111_090349_change_date_column_to_news_table cannot be reverted.\n";

        return false;
    }
    */
}
