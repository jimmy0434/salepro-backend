<?php

use yii\db\Migration;

/**
 * Class m211207_103840_Add_greek_to_news_table
 */
class m211207_103840_Add_greek_to_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%news}}', 'titletr',  $this->string());
        $this->addColumn('{{%news}}', 'detailstr',  $this->string());


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211207_103840_Add_greek_to_news_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211207_103840_Add_greek_to_news_table cannot be reverted.\n";

        return false;
    }
    */
}
