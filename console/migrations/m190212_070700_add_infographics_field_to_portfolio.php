<?php

use cnd\core\components\Migration;

/**
 * Class m190212_070700_add_infographics_field_to_portfolio
 */
class m190212_070700_add_infographics_field_to_portfolio extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->safeOperation(function () {
            $this->addColumn('{{%portfolio}}', 'info_graphic_id', $this->integer());
            $this->createIndexForeignKey('portfolio.info_graphic_id', 'file.id');
        });
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190212_070700_add_infographics_field_to_portfolio cannot be reverted.\n";

        return false;
    }
}
