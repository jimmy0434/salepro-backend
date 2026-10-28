<?php

use cnd\core\components\Migration;

/**
 * Handles the creation of table `{{%news_sector}}`.
 */
class m230123_191701_create_news_sector_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%news_sector}}', [
            'id' => $this->primaryKey(),
            'news_id' => $this->integer(),
            'sector_id' => $this->integer(),
        ]);
        $this->safeOperation(function () {
            $this->createIndexForeignKey('news_sector.news_id','news.id');
            $this->createIndexForeignKey('news_sector.sector_id','sector.id');
          
        });
    }

   
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%news_sector}}');
    }
}
