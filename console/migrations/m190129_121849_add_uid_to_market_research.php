<?php

use cnd\core\components\Migration;

/**
 * Class m190129_121849_add_uid_to_market_research
 */
class m190129_121849_add_uid_to_market_research extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%market_research}}','uid', $this->string()->unique());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190129_121849_add_uid_to_market_research cannot be reverted.\n";

        return false;
    }
}
