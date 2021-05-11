<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%steep}}`.
 */
class m210226_224521_create_steep_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%steep}}', [
            'id' => $this->primaryKey(),
            'uid' => $this->string()->unique(),
            'name'=>$this->string(),
            'target'=> $this->integer(),
            'search_id'=>$this->integer(),
            'url'=>$this->string(),
            'file_id'=> $this->integer(),
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
        $this->dropTable('{{%steep}}');
    }
}
