<?php

use cnd\core\components\Migration;

/**
 * Class m190206_062401_add_product_details_tables_and_content
 */
class m190206_062401_add_product_details_tables_and_content extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%exhibition}}', 'sector_id', $this->integer());

        $this->createTable('content', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'text' => $this->longText(),
            'image' => $this->longText(),
        ]);

        $this->createTable('product_detail', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'section' => $this->tinyInteger(),
            'title' => $this->string(),
        ]);

        $this->createTable('product_detail_item', [
            'id' => $this->primaryKey(),
            'product_detail_id' => $this->integer(),
            'file_id' => $this->integer(),
            'content_id' => $this->integer(),
            'type' => $this->tinyInteger(),
            'title' => $this->string(),
        ]);

        $this->safeOperation(function () {
            $this->createIndexForeignKey('exhibition.sector_id', 'sector.id', 'SET NULL');

            $this->createIndexForeignKey('product_detail.product_id', 'product.id');
            $this->createIndexForeignKey('product_detail_item.product_detail_id', 'product_detail.id');
            $this->createIndexForeignKey('product_detail_item.file_id', 'file.id');
            $this->createIndexForeignKey('product_detail_item.content_id', 'content.id');
        });
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190206_062401_add_product_details_tables_and_content cannot be reverted.\n";

        return false;
    }
}
