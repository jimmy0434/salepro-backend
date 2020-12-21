<?php

use yii\db\Migration;

/**
 * Handles adding details to table `{{%news}}`.
 */
class m201207_115925_add_details_column_to_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%news}}', 'details', $this->text()->after('title'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%news}}', 'details');
    }
}
