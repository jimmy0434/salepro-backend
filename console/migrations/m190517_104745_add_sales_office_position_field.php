<?php

use cnd\core\components\Migration;

/**
 * Class m190517_104745_add_sales_office_position_field
 */
class m190517_104745_add_sales_office_position_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%sales_office}}', 'position', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190517_104745_add_sales_office_position_field cannot be reverted.\n";

        return false;
    }
}
