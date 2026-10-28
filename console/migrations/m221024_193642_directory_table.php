<?php

use yii\db\Migration;

/**
 * Class m221024_193642_directory_table
 */
class m221024_193642_directory_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('{{%directory}}', [
            'id' => $this->primaryKey(),
            'uid' => $this->string()->unique(),
            'name' => $this->string(),
            'title' => $this->string(),
            'phone' => $this->string(),
            'ext' => $this->string(),
            'cell' => $this->string(),
            'email' => $this->string(),
            'bu' => $this->string(),
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
        echo "m221024_193642_directory_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221024_193642_directory_table cannot be reverted.\n";

        return false;
    }
    */
}
