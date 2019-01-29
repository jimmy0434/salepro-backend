<?php

use cnd\core\components\Migration;

/**
 * Class m190129_101805_edit_market_research_table
 */
class m190129_101805_edit_market_research_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('market_research_product', [
            'id' => $this->primaryKey(),
            'market_research_id' => $this->integer(),
            'product_id' => $this->integer(),
        ]);

        $this->safeOperation(function () {
            $this->removeIndexForeignKey('market_research.product_id');
            $this->dropColumn('{{%market_research}}', 'product_id');

            $this->addColumn('{{%market_research}}', 'name', $this->string());
            $this->addColumn('{{%market_research}}', 'sector_id', $this->integer());
            $this->createIndexForeignKey('market_research.sector_id', 'sector.id');

            $this->createIndexForeignKey('market_research_product.market_research_id', 'market_research.id');
            $this->createIndexForeignKey('market_research_product.product_id', 'product.id');
        });
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190129_101805_edit_market_research_table cannot be reverted.\n";

        return false;
    }
}
