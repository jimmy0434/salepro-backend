<?php

use cnd\core\components\Migration;

/**
 * Class m190124_123325_add_solution_tables
 */
class m190124_123325_add_solution_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('portfolio',[
            'id' => $this->primaryKey(),
            'uid' => $this->string()->unique(),
            'name' => $this->string(),
            'description' => $this->longText(),
            'image' => $this->mediumText(),
            'brochure_id' => $this->integer(),
            'presentation_id' => $this->integer(),
            'video_id' => $this->integer(),
            'search_id' => $this->integer(),
            'target' => $this->tinyInteger(),
        ]);

        $this->createTable('corporate',[
            'id' => $this->primaryKey(),
            'uid' => $this->string()->unique(),
            'portfolio_id' => $this->integer(),
        ]);

        $this->createTable('brand',[
            'id' => $this->primaryKey(),
            'uid' => $this->string()->unique(),
            'portfolio_id' => $this->integer(),
        ]);

        $this->createTable('sector',[
            'id' => $this->primaryKey(),
            'uid' => $this->string()->unique(),
            'portfolio_id' => $this->integer(),
        ]);

        $this->createTable('product',[
            'id' => $this->primaryKey(),
            'uid' => $this->string()->unique(),
            'portfolio_id' => $this->integer(),
        ]);

        $this->createTable('business_unit',[
            'id' => $this->primaryKey(),
            'uid' => $this->string()->unique(),
            'name' => $this->string(),
            'type' => $this->tinyInteger(),
            'image' => $this->mediumText(),
        ]);

        $this->createTable('corporate_sector', [
            'id' => $this->primaryKey(),
            'corporate_id' => $this->integer(),
            'sector_id' => $this->integer(),
        ]);

        $this->createTable('corporate_business_unit', [
            'id' => $this->primaryKey(),
            'corporate_id' => $this->integer(),
            'business_unit_id' => $this->integer(),
        ]);

        $this->createTable('brand_business_unit', [
            'id' => $this->primaryKey(),
            'brand_id' => $this->integer(),
            'business_unit_id' => $this->integer(),
        ]);

        $this->createTable('sector_business_unit', [
            'id' => $this->primaryKey(),
            'sector_id' => $this->integer(),
            'business_unit_id' => $this->integer(),
        ]);

        $this->createTable('product_sector', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'sector_id' => $this->integer(),
        ]);

        $this->createTable('product_brand', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'brand_id' => $this->integer(),
        ]);

        $this->createTable('sector_brand', [
            'id' => $this->primaryKey(),
            'sector_id' => $this->integer(),
            'brand_id' => $this->integer(),
        ]);

        $this->createTable('search', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'text' => $this->longText(),
            'target' => $this->string(),
        ]);

        $this->createTable('tag', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->unique(),
        ]);

        $this->createTable('search_tag', [
            'id' => $this->primaryKey(),
            'search_id' => $this->integer(),
            'tag_id' => $this->integer(),
        ]);

        $this->createTable('exhibition', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'country' => $this->string(),
            'region' => $this->string(),
            'year' => $this->string(),
            'file_id' => $this->integer(),
            'business_unit_id' => $this->integer(),
        ]);

        $this->createTable('exhibition_item', [
            'id' => $this->primaryKey(),
            'exhibition_id' => $this->integer(),
            'by' => $this->tinyInteger(),
        ]);

        $this->createTable('exhibition_item_product', [
            'id' => $this->primaryKey(),
            'exhibition_id' => $this->integer(),
            'exhibition_item_id' => $this->integer(),
            'product_id' => $this->integer(),
        ]);

        $this->createTable('market_research', [
            'id' => $this->primaryKey(),
            'country' => $this->string(),
            'region' => $this->string(),
            'year' => $this->string(),
            'source' => $this->string(),
            'product_id' => $this->integer(),
            'file_id' => $this->integer(),
            'search_id' => $this->integer(),
        ]);

        $this->createTable('portfolio_link', [
            'id' => $this->primaryKey(),
            'portfolio_id' => $this->integer(),
            'image' => $this->mediumText(),
            'url' => $this->text(),
        ]);

        $this->createTable('portfolio_news', [
            'id' => $this->primaryKey(),
            'portfolio_id' => $this->integer(),
            'url' => $this->text(),
        ]);

        $this->createTable('portfolio_competitor', [
            'id' => $this->primaryKey(),
            'portfolio_id' => $this->integer(),
            'competitor_id' => $this->integer(),
        ]);

        $this->createTable('competitor', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'image' => $this->mediumText(),
            'market_presence' => $this->string(),
            'year' => $this->string(),
            'product' => $this->string(),
            'business_unit' => $this->string(),
            'form_id' => $this->integer(),
            'form_record_id' => $this->integer(),
            'search_id' => $this->integer(),
        ]);

        $this->addRelations(function(){
            
            $this->createIndexForeignKey('portfolio.brochure_id','file.id');
            $this->createIndexForeignKey('portfolio.presentation_id','file.id');
            $this->createIndexForeignKey('portfolio.video_id','file.id');
            $this->createIndexForeignKey('portfolio.search_id','search.id');

            $this->createIndexForeignKey('corporate.portfolio_id','portfolio.id');
            $this->createIndexForeignKey('brand.portfolio_id','portfolio.id');
            $this->createIndexForeignKey('sector.portfolio_id','portfolio.id');
            $this->createIndexForeignKey('product.portfolio_id','portfolio.id');

            $this->createIndexForeignKey('corporate_sector.corporate_id','corporate.id');
            $this->createIndexForeignKey('corporate_sector.sector_id','sector.id');

            $this->createIndexForeignKey('corporate_business_unit.corporate_id','corporate.id');
            $this->createIndexForeignKey('corporate_business_unit.business_unit_id','business_unit.id');

            $this->createIndexForeignKey('brand_business_unit.brand_id','brand.id');
            $this->createIndexForeignKey('brand_business_unit.business_unit_id','business_unit.id');

            $this->createIndexForeignKey('sector_business_unit.sector_id','sector.id');
            $this->createIndexForeignKey('sector_business_unit.business_unit_id','business_unit.id');

            $this->createIndexForeignKey('product_sector.product_id','product.id');
            $this->createIndexForeignKey('product_sector.sector_id','sector.id');

            $this->createIndexForeignKey('product_brand.product_id','product.id');
            $this->createIndexForeignKey('product_brand.brand_id','brand.id');

            $this->createIndexForeignKey('sector_brand.sector_id','sector.id');
            $this->createIndexForeignKey('sector_brand.brand_id','brand.id');

            $this->createIndexForeignKey('search_tag.search_id','search.id');
            $this->createIndexForeignKey('search_tag.tag_id','tag.id');

            $this->createIndexForeignKey('exhibition.file_id','file.id', 'SET NULL');
            $this->createIndexForeignKey('exhibition.business_unit_id','business_unit.id', 'SET NULL');
            $this->createIndexForeignKey('exhibition_item.exhibition_id','exhibition.id');
            $this->createIndexForeignKey('exhibition_item_product.exhibition_id','exhibition.id');
            $this->createIndexForeignKey('exhibition_item_product.exhibition_item_id','exhibition_item.id');
            $this->createIndexForeignKey('exhibition_item_product.product_id','product.id', 'SET NULL');

            $this->createIndexForeignKey('market_research.product_id','product.id', 'SET NULL');
            $this->createIndexForeignKey('market_research.file_id','file.id', 'SET NULL');
            $this->createIndexForeignKey('market_research.search_id','search.id', 'SET NULL');

            $this->createIndexForeignKey('portfolio_link.portfolio_id','portfolio.id');
            $this->createIndexForeignKey('portfolio_news.portfolio_id','portfolio.id');

            $this->createIndexForeignKey('competitor.form_id','form.id', 'SET NULL');
            $this->createIndexForeignKey('competitor.search_id','search.id', 'SET NULL');

            $this->createIndexForeignKey('portfolio_competitor.portfolio_id','portfolio.id');
            $this->createIndexForeignKey('portfolio_competitor.competitor_id','competitor.id');
        });

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190124_123325_add_solution_tables cannot be reverted.\n";

        return false;
    }
}
