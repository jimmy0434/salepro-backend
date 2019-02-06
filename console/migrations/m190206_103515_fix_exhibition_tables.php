<?php

use cnd\core\components\Migration;

/**
 * Class m190206_103515_fix_exhibition_tables
 */
class m190206_103515_fix_exhibition_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190206_103515_fix_exhibition_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190206_103515_fix_exhibition_tables cannot be reverted.\n";

        return false;
    }
    */
}
