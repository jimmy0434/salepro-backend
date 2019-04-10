<?php

use cnd\core\components\Migration;

/**
 * Class m190410_065020_add_status_fields_to_some_tables
 */
class m190410_065020_add_status_fields_to_some_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%portfolio}}', 'status', 'enum("enabled","disabled") DEFAULT "enabled"');
        $this->addColumn('{{%competitor}}', 'status', 'enum("enabled","disabled") DEFAULT "enabled"');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190410_065020_add_status_fields_to_some_tables cannot be reverted.\n";

        return false;
    }
}
