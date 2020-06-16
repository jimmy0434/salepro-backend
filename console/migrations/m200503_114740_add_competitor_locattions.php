<?php

use cnd\core\components\Migration;

/**
 * Class m200503_114740_add_competitor_locattions
 */
class m200503_114740_add_competitor_locattions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%competitor}}', 'manufacturing_locations', $this->text());
        $this->addColumn('{{%competitor}}', 'sales_offices_locations', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%competitor}}', 'manufacturing_locations');
        $this->dropColumn('{{%competitor}}', 'sales_offices_locations');

        return true;
    }

}
