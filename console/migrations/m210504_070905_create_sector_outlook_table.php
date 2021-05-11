<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sector_outlook}}`.
 */
class m210504_070905_create_sector_outlook_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sector_outlook}}', [
            'id' => $this->primaryKey(),
            'uid' => $this->string()->unique(),
            'salesman_id' => $this->integer(),
            'name'=>$this->string(),
            'industry'=>$this->string(),
            'country'=>$this->string(),
            'outlook'=>$this->string(),
            'source'=>$this->string(),
            'growth_rate'=>$this->string(),
            'file' => 'longblob',
            'file_ext' =>$this->string(),
            'created_at'=>
            $this->integer()->defaultValue(null),
            'updated_at'=>
            $this->integer()->defaultValue(null)
        ]);
        $this->addForeignKey(
            'saleman_id_outlook',
           
            '{{%sector_outlook}}',
            'salesman_id',
            '{{%salesman}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%sector_outlook}}');
    }
}
