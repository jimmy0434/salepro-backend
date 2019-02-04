<?php

use cnd\core\components\Migration;

/**
 * Class m190204_124016_add_sustainability_and_sales_office_tables
 */
class m190204_124016_add_sustainability_and_sales_office_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('sustainability', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'image' => $this->longText(),
            'power_point' => $this->integer(),
            'brochure' => $this->integer(),
            'video' => $this->integer(),
            'url' => $this->text(),
        ]);

        $this->createTable('sales_office', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'content' => $this->longText(),
        ]);

        $this->createTable('portfolio_sales_office', [
            'id' => $this->primaryKey(),
            'portfolio_id' => $this->integer(),
            'sales_office_id' => $this->integer(),
        ]);

        $this->safeOperation(function () {
            $this->createIndexForeignKey('sustainability.power_point', 'file.id', 'SET NULL');
            $this->createIndexForeignKey('sustainability.brochure', 'file.id', 'SET NULL');
            $this->createIndexForeignKey('sustainability.video', 'file.id', 'SET NULL');
            $this->createIndexForeignKey('portfolio_sales_office.portfolio_id', 'portfolio.id');
            $this->createIndexForeignKey('portfolio_sales_office.sales_office_id', 'sales_office.id');
        });
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190204_124016_add_sustainability_and_sales_office_tables cannot be reverted.\n";

        return false;
    }
}
