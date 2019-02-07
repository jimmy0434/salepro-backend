<?php

use cnd\core\components\Migration;

/**
 * Class m190207_134131_fix_competition_foreignkey
 */
class m190207_134131_fix_competition_foreignkey extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->safeOperation(function(){
            $this->removeIndexForeignKey('competitor_flexible_customer.competitor_flexible_id');
            $this->removeIndexForeignKey('competitor_packaging_customer.competitor_packaging_id');
            $this->removeIndexForeignKey('competitor_masterbatch_customer.competitor_masterbatch_id');

            $this->createIndexForeignKey('competitor_flexible_customer.competitor_flexible_id', 'competitor_flexible.id');
            $this->createIndexForeignKey('competitor_packaging_customer.competitor_packaging_id', 'competitor_packaging.id');
            $this->createIndexForeignKey('competitor_masterbatch_customer.competitor_masterbatch_id', 'competitor_masterbatch.id');
        });
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190207_134131_fix_competition_foreignkey cannot be reverted.\n";

        return false;
    }
}
