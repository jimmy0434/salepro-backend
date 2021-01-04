<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%news}}`.
 */
class m210104_061918_create_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%news}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'details' => $this->Text(),
            'image' => $this->Text(),
            'source' => $this->string(),
            'url' => $this->Text(),
            'source_person' => $this->string(),
            'created_at'=>
            $this->integer()->defaultValue(null),
            'updated_at'=>
            $this->integer()->defaultValue(null)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%news}}');
    }
}
