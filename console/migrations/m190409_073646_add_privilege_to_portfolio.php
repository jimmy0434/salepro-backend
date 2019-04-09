<?php

use cnd\core\components\Migration;

/**
 * Class m190409_073646_add_privilege_to_portfolio
 */
class m190409_073646_add_privilege_to_portfolio extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%portfolio}}','privilege', $this->longText());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190409_073646_add_privilege_to_portfolio cannot be reverted.\n";

        return false;
    }
}
