<?php


use cnd\core\components\Migration;

/**
 * Handles the creation of table `{{%news_type}}`.
 */
class m230217_110605_create_news_type_table extends Migration
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
            'created_at' =>  $this->integer()->defaultValue(null),
            'updated_at' =>  $this->integer()->defaultValue(null)
       

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
