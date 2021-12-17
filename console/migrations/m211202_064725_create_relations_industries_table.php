<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%relations_industries}}`.
 */
class m211202_064725_create_relations_industries_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%relations_industries}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%relations_industries}}');
    }
}
