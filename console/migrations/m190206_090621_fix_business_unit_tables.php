<?php

use cnd\core\components\Migration;

/**
 * Class m190206_090621_fix_business_unit_tables
 */
class m190206_090621_fix_business_unit_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%business_unit}}', 'name');
        $this->dropColumn('{{%business_unit}}', 'type');
        $this->dropColumn('{{%business_unit}}', 'image');
        $this->addColumn('{{%business_unit}}', 'portfolio_id', $this->integer());
        $this->safeOperation(function () {
            $this->createIndexForeignKey('business_unit.portfolio_id', 'portfolio.id');
        });
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190206_090621_fix_business_unit_tables cannot be reverted.\n";

        return false;
    }
}
