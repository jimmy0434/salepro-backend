<?php

use cnd\core\components\Migration;

/**
 * Class m200414_143711_drop_competitpr_sector_id
 */
class m200414_143711_drop_competitpr_sector_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%competitor_flexible}}', 'sector_id');
        $this->dropColumn('{{%competitor_masterbatch}}', 'sector_id');
        $this->dropColumn('{{%competitor_packaging}}', 'sector_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200414_143711_drop_competitpr_sector_id cannot be reverted.\n";

        return false;
    }

}
