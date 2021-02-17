<?php

use yii\db\Migration;

/**
 * Handles adding more_than_one_docs to table `{{%portfolio}}`.
 */
class m210201_080609_add_more_than_one_docs_column_to_portfolio_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%portfolio}}', 'brochure_idd',  $this->integer());
        $this->addColumn('{{%portfolio}}', 'brochure_iddd',  $this->integer());
        $this->addColumn('{{%portfolio}}', 'presentation_idd',  $this->integer());
        $this->addColumn('{{%portfolio}}', 'presentation_iddd',  $this->integer());
        $this->addColumn('{{%portfolio}}', 'video_idd',  $this->integer());
        $this->addColumn('{{%portfolio}}', 'video_iddd',  $this->integer());
        $this->addColumn('{{%portfolio}}', 'info_graphic_idd',  $this->integer());
        $this->addColumn('{{%portfolio}}', 'info_graphic_iddd',  $this->integer());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
