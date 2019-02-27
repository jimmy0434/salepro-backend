<?php

use cnd\core\components\Migration;

/**
 * Class m190227_072619_add_certification_tables
 */
class m190227_072619_add_certification_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('certification', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'image' => $this->longText(),
            'file_id' => $this->integer(),
        ]);

        $this->createTable('product_certification', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'certification_id' => $this->integer(),
        ]);
        $this->createTable('business_unit_certification', [
            'id' => $this->primaryKey(),
            'business_unit_id' => $this->integer(),
            'certification_id' => $this->integer(),
        ]);

        $this->safeOperation(function () {
            $this->createIndexForeignKey('certification.file_id', 'file.id', 'SET NULL');
            $this->createIndexForeignKey('product_certification.certification_id', 'certification.id');
            $this->createIndexForeignKey('product_certification.product_id', 'product.id');
            $this->createIndexForeignKey('business_unit_certification.certification_id', 'certification.id');
            $this->createIndexForeignKey('business_unit_certification.business_unit_id', 'business_unit.id');
        });
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190227_072619_add_certification_tables cannot be reverted.\n";

        return false;
    }
}
