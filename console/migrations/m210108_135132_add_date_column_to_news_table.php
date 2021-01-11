<?php

use yii\db\Migration;

/**
 * Handles adding date to table `{{%news}}`.
 */
class m210108_135132_add_date_column_to_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%news}}', 'date', $this->timestamp());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%news}}', 'date');
    }
}
