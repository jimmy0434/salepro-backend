<?php

use yii\db\Migration;

/**
 * Handles adding new to table `{{%news}}`.
 */
class m210125_080830_add_new_column_to_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn('{{%news}}', 'uid' , $this->string()->unique());
        $this->addColumn('{{%news}}', 'sector_id',  $this->integer());
        $this->addColumn('{{%news}}', 'search_id',  $this->integer());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
