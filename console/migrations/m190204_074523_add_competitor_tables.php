<?php

use cnd\core\components\Migration;

/**
 * Class m190204_074523_add_competitor_tables
 */
class m190204_074523_add_competitor_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->safeOperation(function () {
            $this->removeIndexForeignKey('competitor.search_id');
            $this->removeIndexForeignKey('competitor.form_id');
            $this->removeIndexForeignKey('portfolio_competitor.portfolio_id');
            $this->removeIndexForeignKey('portfolio_competitor.competitor_id');
            $this->dropTable('{{%competitor}}');
        });

        $this->createTable('competitor', [
            'id' => $this->primaryKey(),
            'uid' => $this->string()->unique(),
            'salesman_id' => $this->integer(),
            'name' => $this->string(),
            'business_unit_id' => $this->integer(),
            'company_profile' => $this->string(),
            'headquarter_location' => $this->string(),
            'other_locations' => $this->string(),
            'website' => $this->string(),
            'logo' => 'longblob',
            'market_presence' => $this->string(),
            'established_year' => $this->string(),
            'annual_sales_revenue' => $this->string(),
            'employees_number' => $this->string(),
            'certification' => $this->string(),
            'certification_others' => $this->string(),
            'marketing_strategy' => $this->string(),
            'company_communication' => $this->string(),
            'quality' => $this->string(),
            'brand_equity' => $this->string(),
            'problem_solving_response' => $this->string(),
            'market_dominance' => $this->string(),
            'comments' => $this->string(),
            'file' => 'longblob',
            'mother_name' => $this->string(),
            'mother_company_profile' => $this->string(),
            'mother_headquarter_location' => $this->string(),
            'mother_other_locations' => $this->string(),
            'mother_website' => $this->string(),
            'search_id' => $this->integer(),
        ]);

        $this->createTable('competitor_manager', [
            'id' => $this->primaryKey(),
            'competitor_id' => $this->integer(),
            'first_name' => $this->string(),
            'last_name' => $this->string(),
            'position' => $this->string(),
            'linkedin' => $this->text(),
        ]);

        $this->createTable('competitor_social', [
            'id' => $this->primaryKey(),
            'competitor_id' => $this->integer(),
            'social_media' => $this->string(),
            'url' => $this->text(),
        ]);

        $this->createTable('competitor_production_line', [
            'id' => $this->primaryKey(),
            'competitor_id' => $this->integer(),
            'production_line' => $this->string(),
            'colors_number' => $this->string(),
            'layers_number' => $this->string(),
            'brand_line' => $this->string(),
            'output' => $this->string(),
            'unit' => $this->string(),
            'width' => $this->string(),
            'machines_number' => $this->string(),
        ]);

        $this->createTable('competitor_supplier', [
            'id' => $this->primaryKey(),
            'competitor_id' => $this->integer(),
            'raw_material' => $this->string(),
            'supplier_name' => $this->string(),
            'country' => $this->string(),
        ]);

        $this->createTable('competitor_news', [
            'id' => $this->primaryKey(),
            'competitor_id' => $this->integer(),
            'url' => $this->text(),
        ]);

        $this->createTable('competitor_flexible', [
            'id' => $this->primaryKey(),
            'competitor_id' => $this->integer(),
            'product_type' => $this->string(),
            'sector_id' => $this->integer(),
            'quantity_sold' => $this->string(),
            'quantity_unit' => $this->string(),
            'thickness' => $this->string(),
            'width' => $this->string(),
            'color' => $this->string(),
            'printing_colors_number' => $this->string(),
            'embossed' => $this->boolean(),
            'perforated' => $this->boolean(),
            'core_id' => $this->string(),
            'business_terms' => $this->string(),
            'incoterms' => $this->string(),
            'payment' => $this->string(),
            'price' => $this->string(),
            'currency' => $this->string(),
        ]);

        $this->createTable('competitor_flexible_customer', [
            'id' => $this->primaryKey(),
            'competitor_id' => $this->integer(),
            'competitor_flexible_id' => $this->integer(),
            'name' => $this->string(),
            'country' => $this->string(),
            'share_percentage' => $this->string(),
        ]);

        $this->createTable('competitor_packaging', [
            'id' => $this->primaryKey(),
            'competitor_id' => $this->integer(),
            'product_type' => $this->string(),
            'sector_id' => $this->integer(),
            'quantity_sold' => $this->string(),
            'quantity_unit' => $this->string(),
            'material' => $this->string(),
            'weight' => $this->string(),
            'diameter' => $this->string(),
            'color' => $this->string(),
            'height' => $this->string(),
            'neck' => $this->string(),
            'ctn_volume' => $this->string(),
            'business_terms' => $this->string(),
            'incoterms' => $this->string(),
            'payment' => $this->string(),
            'price' => $this->string(),
            'currency' => $this->string(),
        ]);

        $this->createTable('competitor_packaging_customer', [
            'id' => $this->primaryKey(),
            'competitor_id' => $this->integer(),
            'competitor_packaging_id' => $this->integer(),
            'name' => $this->string(),
            'country' => $this->string(),
            'share_percentage' => $this->string(),
        ]);

        $this->createTable('competitor_masterbatch', [
            'id' => $this->primaryKey(),
            'competitor_id' => $this->integer(),
            'product_type' => $this->string(),
            'sector_id' => $this->integer(),
            'quantity_sold' => $this->string(),
            'quantity_unit' => $this->string(),
            'active_ingredient' => $this->string(),
            'mfi' => $this->string(),
            'resin_type' => $this->string(),
            'ink_type' => $this->string(),
            'outdoor' => $this->string(),
            'food_grade' => $this->string(),
            'business_terms' => $this->string(),
            'incoterms' => $this->string(),
            'payment' => $this->string(),
            'price' => $this->string(),
            'currency' => $this->string(),
        ]);

        $this->createTable('competitor_masterbatch_customer', [
            'id' => $this->primaryKey(),
            'competitor_id' => $this->integer(),
            'competitor_masterbatch_id' => $this->integer(),
            'name' => $this->string(),
            'country' => $this->string(),
            'share_percentage' => $this->string(),
        ]);

        $this->safeOperation(function () {
            $this->createIndexForeignKey('competitor.search_id', 'search.id', 'SET NULL');
            $this->createIndexForeignKey('competitor.business_unit_id', 'business_unit.id', 'SET NULL');
            $this->createIndexForeignKey('competitor.salesman_id', 'salesman.id', 'SET NULL');

            $this->createIndexForeignKey('portfolio_competitor.portfolio_id', 'portfolio.id');
            $this->createIndexForeignKey('portfolio_competitor.competitor_id', 'competitor.id');

            $this->createIndexForeignKey('competitor_manager.competitor_id', 'competitor.id');
            $this->createIndexForeignKey('competitor_social.competitor_id', 'competitor.id');
            $this->createIndexForeignKey('competitor_production_line.competitor_id', 'competitor.id');
            $this->createIndexForeignKey('competitor_supplier.competitor_id', 'competitor.id');
            $this->createIndexForeignKey('competitor_news.competitor_id', 'competitor.id');

            $this->createIndexForeignKey('competitor_flexible.competitor_id', 'competitor.id');
            $this->createIndexForeignKey('competitor_flexible.sector_id', 'sector.id');
            $this->createIndexForeignKey('competitor_flexible_customer.competitor_id', 'competitor.id');
            $this->createIndexForeignKey('competitor_flexible_customer.competitor_flexible_id', 'competitor_flexible_customer.id');

            $this->createIndexForeignKey('competitor_packaging.competitor_id', 'competitor.id');
            $this->createIndexForeignKey('competitor_packaging.sector_id', 'sector.id');
            $this->createIndexForeignKey('competitor_packaging_customer.competitor_id', 'competitor.id');
            $this->createIndexForeignKey('competitor_packaging_customer.competitor_packaging_id', 'competitor_packaging_customer.id');

            $this->createIndexForeignKey('competitor_masterbatch.competitor_id', 'competitor.id');
            $this->createIndexForeignKey('competitor_masterbatch.sector_id', 'sector.id');
            $this->createIndexForeignKey('competitor_masterbatch_customer.competitor_id', 'competitor.id');
            $this->createIndexForeignKey('competitor_masterbatch_customer.competitor_masterbatch_id', 'competitor_masterbatch_customer.id');
        });
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190204_074523_add_competitor_tables cannot be reverted.\n";

        return false;
    }
}
