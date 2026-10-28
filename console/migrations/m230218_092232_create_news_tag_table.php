<?php

use cnd\core\components\Migration;

/**
 * Handles the creation of table `{{%news_tag}}`.
 */
class m230218_092232_create_news_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      
        $this->addColumn('{{%News}}', 'news_steep',  $this->string());
        $this->createTable('{{%news_tag}}', [
            'id' => $this->primaryKey(),
            'news_id' => $this->integer(),
            'tag' => $this->string(),
            'created_at' =>  $this->integer()->defaultValue(null),
            'updated_at' =>  $this->integer()->defaultValue(null)
       

        ]);
        $this->safeOperation(function () {
            $this->createIndexForeignKey('news_tag.news_id','news.id');
  
          
        });
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%news_tag}}');
    }
}
