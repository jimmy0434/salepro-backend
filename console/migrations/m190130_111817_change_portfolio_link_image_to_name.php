<?php

use cnd\core\components\Migration;

/**
 * Class m190130_111817_change_portfolio_link_image_to_name
 */
class m190130_111817_change_portfolio_link_image_to_name extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('{{%portfolio_link}}','image','name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190130_111817_change_portfolio_link_image_to_name cannot be reverted.\n";

        return false;
    }
}
