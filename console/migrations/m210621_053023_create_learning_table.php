<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%learning}}`.
 */
class m210621_053023_create_learning_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%learning}}', [
            'id' => $this->primaryKey(),
            'uid' => $this->string()->unique(),
            'name'=>$this->string(),
            'description'=>$this->string(),
            'image' => $this->Text(),
            'trainer'=>$this->string(),
            'target'=> $this->integer(),
            'parent_id'=> $this->integer(),
            'search_id'=>$this->integer(),
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
        $this->dropTable('{{%learning}}');
    }
}
