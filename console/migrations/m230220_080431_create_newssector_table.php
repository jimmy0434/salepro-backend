<?php

use cnd\core\components\Migration;

/**
 * Handles the creation of table `{{%newssector}}`.
 */
class m230220_080431_create_newssector_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%news_sector}}', [
            'id' => $this->primaryKey(),
            'news_id' => $this->integer(),
            'sector' => $this->string(),
            'created_at' =>  $this->integer()->defaultValue(null),
            'updated_at' =>  $this->integer()->defaultValue(null)
       

        ]);
        $this->safeOperation(function () {
            $this->createIndexForeignKey('news_sector.news_id','news.id');
  
          
        });
    }
    

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%newssector}}');
    }
}
