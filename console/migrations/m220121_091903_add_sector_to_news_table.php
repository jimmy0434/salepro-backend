<?php

use yii\db\Migration;

/**
 * Class m220121_091903_add_sector_to_news_table
 */
class m220121_091903_add_sector_to_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%news}}', 'sector',  $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220121_091903_add_sector_to_news_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220121_091903_add_sector_to_news_table cannot be reverted.\n";

        return false;
    }
    */
}
