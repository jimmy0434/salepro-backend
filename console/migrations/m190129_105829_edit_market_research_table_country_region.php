<?php

use cnd\core\components\Migration;

/**
 * Class m190129_105829_edit_market_research_table_country_region
 */
class m190129_105829_edit_market_research_table_country_region extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%market_research}}','country');
        $this->dropColumn('{{%market_research}}','region');

        $this->createTable('market_research_country',[
            'id' => $this->primaryKey(),
            'market_research_id' => $this->integer(),
            'country' => $this->string(),
        ]);

        $this->createTable('market_research_region',[
            'id' => $this->primaryKey(),
            'market_research_id' => $this->integer(),
            'region' => $this->string(),
        ]);

        $this->safeOperation(function(){
            $this->createIndexForeignKey('market_research_country.market_research_id','market_research.id');
            $this->createIndexForeignKey('market_research_region.market_research_id','market_research.id');
        });
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190129_105829_edit_market_research_table_country_region cannot be reverted.\n";

        return false;
    }
}
