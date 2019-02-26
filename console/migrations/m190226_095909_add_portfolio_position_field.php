<?php

use cnd\core\components\Migration;

/**
 * Class m190226_095909_add_portfolio_position_field
 */
class m190226_095909_add_portfolio_position_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%portfolio}}','position', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190226_095909_add_portfolio_position_field cannot be reverted.\n";

        return false;
    }
}
