<?php

use cnd\core\components\Migration;

/**
 * Class m190715_062431_fix_corporates_to_many_fields
 */
class m190715_062431_fix_competitor_to_many_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('competitor_other_location', [
            'id' => $this->primaryKey(),
            'competitor_id' => $this->integer(),
            'value' => $this->string(),
        ]);

        $this->createTable('competitor_mother_other_location', [
            'id' => $this->primaryKey(),
            'competitor_id' => $this->integer(),
            'value' => $this->string(),
        ]);

        $this->createTable('competitor_market_presence', [
            'id' => $this->primaryKey(),
            'competitor_id' => $this->integer(),
            'value' => $this->string(),
        ]);

        $this->createTable('competitor_certification', [
            'id' => $this->primaryKey(),
            'competitor_id' => $this->integer(),
            'value' => $this->string(),
            'other' => $this->boolean(),
        ]);

        $this->createTable('competitor_marketing_strategy', [
            'id' => $this->primaryKey(),
            'competitor_id' => $this->integer(),
            'value' => $this->string(),
        ]);

        $this->createTable('competitor_company_communication', [
            'id' => $this->primaryKey(),
            'competitor_id' => $this->integer(),
            'value' => $this->string(),
        ]);

        $this->safeOperation(function(){
            $this->createIndexForeignKey('competitor_other_location.competitor_id', 'competitor.id');
            $this->createIndexForeignKey('competitor_mother_other_location.competitor_id', 'competitor.id');
            $this->createIndexForeignKey('competitor_market_presence.competitor_id', 'competitor.id');
            $this->createIndexForeignKey('competitor_certification.competitor_id', 'competitor.id');
            $this->createIndexForeignKey('competitor_marketing_strategy.competitor_id', 'competitor.id');
            $this->createIndexForeignKey('competitor_company_communication.competitor_id', 'competitor.id');
        });
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190715_062431_fix_corporates_to_many_fields cannot be reverted.\n";

        return false;
    }
}
