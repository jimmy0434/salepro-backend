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
        $this->safeOperation(function () {
            $this->removeIndexForeignKey('exhibition.sector_id');
            $this->dropColumn('{{%exhibition}}', 'sector_id');
            $this->dropColumn('{{%exhibition}}', 'country');
            $this->dropColumn('{{%exhibition}}', 'region');
            $this->removeIndexForeignKey('exhibition_item.exhibition_id');
            $this->removeIndexForeignKey('exhibition_item_product.exhibition_id');
            $this->removeIndexForeignKey('exhibition_item_product.exhibition_item_id');
            $this->removeIndexForeignKey('exhibition_item_product.product_id');
            $this->dropTable('{{%exhibition_item}}');
            $this->dropTable('{{%exhibition_item_product}}');
        });

        $this->createTable('exhibition_sector', [
            'id' => $this->primaryKey(),
            'exhibition_id' => $this->integer(),
            'sector_id' => $this->integer(),
        ]);

        $this->createTable('exhibition_product', [
            'id' => $this->primaryKey(),
            'exhibition_id' => $this->integer(),
            'product_id' => $this->integer(),
        ]);

        $this->createTable('exhibition_country', [
            'id' => $this->primaryKey(),
            'exhibition_id' => $this->integer(),
            'country' => $this->string(),
        ]);

        $this->createTable('exhibition_region', [
            'id' => $this->primaryKey(),
            'exhibition_id' => $this->integer(),
            'region' => $this->string(),
        ]);

        $this->safeOperation(function () {
            $this->createIndexForeignKey('exhibition_sector.exhibition_id','exhibition.id');
            $this->createIndexForeignKey('exhibition_sector.sector_id','sector.id');
            $this->createIndexForeignKey('exhibition_product.exhibition_id','exhibition.id');
            $this->createIndexForeignKey('exhibition_product.product_id','product.id');
            $this->createIndexForeignKey('exhibition_country.exhibition_id','exhibition.id');
            $this->createIndexForeignKey('exhibition_region.exhibition_id','exhibition.id');
        });
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190206_103515_fix_exhibition_tables cannot be reverted.\n";

        return false;
    }
}
