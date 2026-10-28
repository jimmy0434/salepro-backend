<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%Pactgalery}}`.
 */
class m230411_181917_create_Pactgalery_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%Pactgalery}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'file_id' => $this->integer(),
            'created_at' =>  $this->integer()->defaultValue(null),
            'updated_at' =>  $this->integer()->defaultValue(null)

        ]);
       
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%Pactgalery}}');
    }
}
