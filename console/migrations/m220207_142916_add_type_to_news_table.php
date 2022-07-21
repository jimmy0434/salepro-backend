<?php

use yii\db\Migration;

/**
 * Class m220207_142916_add_type_to_news_table
 */
class m220207_142916_add_type_to_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%news}}', 'news_type',  $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220207_142916_add_type_to_news_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220207_142916_add_type_to_news_table cannot be reverted.\n";

        return false;
    }
    */
}
