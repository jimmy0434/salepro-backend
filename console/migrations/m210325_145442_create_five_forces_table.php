<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%five_forces}}`.
 */
class m210325_145442_create_five_forces_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%five_forces}}', [
            'id' => $this->primaryKey(),
            'uid' => $this->string()->unique(),
            'salesman_id'=> $this->integer(),
            'business_unit_id' => $this->integer(),
            'name' => $this->string(),
            
           
           

            'number_of_suppliers' => $this->string(),
            'suppliers_location' => $this->string(),
            'avg_size_supplier' => $this->string(),
            'uniqueness_of_service' => $this->string(),
            'your_ability_to_Subsitute' => $this->string(),
            'switching_costs' => $this->string(),
           
            

            'number_of_buyers' => $this->string(),
            'concentration_of_buyers' => $this->string(),
            'buyers_size_of_orders' => $this->string(),
            'buyers_switching_costs' => $this->string(),
            'buyers_ability_to_integrate' => $this->string(),
            'buyers_price_sensitivity' => $this->string(),
            'buyers_cost_structure' => $this->string(),
            

            'number_of_competitors' => $this->string(),
            'diversity_of__competitors' => $this->string(),
            'product_differenciation_substitutes' => $this->string(),
            'economics_of_scale' => $this->string(),
            'customer_loyality' => $this->string(),
            'customer_switching_cost' => $this->string(),
            'industry_sector_growth' => $this->string(),
         
            
            


            'availability_of_subsitutes' => $this->string(),
            'subsitute_price_vs_industry_product' => $this->string(),
            'subsitute_product_quality_vs_indistry_product' => $this->string(),
            'threat_switching_costs' => $this->string(),
          
          
             



            'specialist_knowledge' => $this->string(),
            'product_differenciation' => $this->string(),
            'brand_name' => $this->string(),
            'initial_capital_investment' => $this->string(),
            'consumer_switching_costs' => $this->string(),
            'access_to_distribution_channels' => $this->string(),
            'technology_protections' => $this->string(),
            'governmental_and_legal_barries' => $this->string(),
            'retaliation' => $this->string(),
        
           

            
            'created_at'=>
            $this->integer()->defaultValue(null),
            'updated_at'=>
            $this->integer()->defaultValue(null)
       


  
   
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%five_forces}}');
    }
}
