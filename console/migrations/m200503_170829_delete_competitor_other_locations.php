<?php

use cnd\core\components\Migration;

/**
 * Class m200503_170829_delete_competitor_other_locations
 */
class m200503_170829_delete_competitor_other_locations extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%competitor}}', 'other_locations');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%competitor}}', 'other_locations', $this->text());

        return true;
    }
}
