<?php


use backend\controllers\FiveForcesController;
use common\models\FiveForces;
use yii\helpers\Html;
use yii\web\View;

$view = $this;
$context = $this->context;

assert($view instanceof View);
assert($context instanceof FiveForcesController);

$this->title = $model->name . ' Five Forces';

$na = "N/A";

?>
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                Basic Information
            </div>
            <table class="table" style="table-layout:fixed;">
                <tbody>
           
                <tr>
                    <th>Product Name</th>
                    <td><?= $model->name ?></td>
                </tr>
                <tr>
                    <th>Business Unit</th>
                    <td>
                        <?php
                        if ($model->businessUnit && $model->businessUnit->portfolio) {
                            echo $model->businessUnit->portfolio->name;
                        } else {
                            echo $na;
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>Salesman</th>
                    <td>
                        <?php
                        if ($model->salesman) {
                            echo $model->salesman->name;
                        } else {
                            echo $na;
                        }
                        ?>
                    </td>
                </tr>
            
                </tbody>
            </table>
        </div>
    </div>

</div>
<div class="row">
<div class="col-md-12">
<div class="panel panel-default">
            <div class="panel-heading">
                Suppliers Location
            </div>
            <table class="table" style="table-layout:fixed;">
                <tbody>
                <tr>
           <div class="col-md-4">
              
                    <th>Number Of Suppliers</th>
                    <td><?= $model->number_of_suppliers ?></td>
                 
                    
                   
         
                </div>
                <div class="col-md-4">
                
                    <th>Suppliers location</th>
                    <td><?= $model->suppliers_location ?></td>
               
                
                </div>
                <div class="col-md-4">
                
                <th>Average Size of Main Suppliers </th>
                    <td><?= $model->avg_size_supplier ?></td>
                  
                </div>
                </tr>
                <tr>
                
           <div class="col-md-4">
              
                  
                    <th>Uniqueness Of Service</th>
                    <td><?= $model->uniqueness_of_service ?></td>
                    
                   
         
                </div>
                <div class="col-md-4">
           
                    <th>Your Ability To Subsitute</th>
                    <td><?= $model->your_ability_to_Subsitute ?></td>
                
                </div>
                <div class="col-md-4">
                
          
                    <th>Switching Costs </th>
                    <td><?= $model->switching_costs ?></td>
                </div>
                </tr>
                
                </tbody>
            </table>
        </div>
</div>
</div>

<div class="row">
<div class="col-md-12">
<div class="panel panel-default">
            <div class="panel-heading">
                Buyer Power
            </div>
            <table class="table" style="table-layout:fixed;">
                <tbody>
                <tr>
           <div class="col-md-4">
              
                    <th>Number Of Buyers</th>
                    <td><?= $model->number_of_buyers ?></td>
                 
         
                </div>
                <div class="col-md-4">
                
                    <th>Concentration Of Buyers</th>
                    <td><?= $model->concentration_of_buyers ?></td>
               
                
                </div>
                <div class="col-md-4">
                
                <th>Buyer's Size Of Orders</th>
                    <td><?= $model->buyers_size_of_orders ?></td>
                  
                </div>
                </tr>
                <tr>
                
           <div class="col-md-4">

           
          
                  
                    <th>Buyer's Switching Costs</th>
                    <td><?= $model->buyers_switching_costs ?></td>
                    
                   
         
                </div>
                <div class="col-md-4">
           
                    <th>Buyer's Ability To Integrate</th>
                    <td><?= $model->buyers_ability_to_integrate ?></td>
                
                </div>
                <div class="col-md-4">
                
          
                    <th>Buyer's Price Sensitivity</th>
                    <td><?= $model->buyers_price_sensitivity ?></td>
                </div>
                </tr>
                <tr>
           <div class="col-md-4">

<th>Importance of the Product in The Buyer's Cost Structure 
</th>
                    <td><?= $model->buyers_cost_structure ?></td>
</div>

                </tr>
                </tbody>
            </table>
        </div>
</div>
</div>
<div class="row">
<div class="col-md-12">
<div class="panel panel-default">
            <div class="panel-heading">
            Competitive Rivalry 

            </div>
            <table class="table" style="table-layout:fixed;">
                <tbody>
                <tr>
           <div class="col-md-4">

                    <th>Number of Competitors</th>
                    <td><?= $model->number_of_competitors ?></td>
                 
         
                </div>
                <div class="col-md-4">
                
                    <th>Diversity Of Competitors</th>
                    <td><?= $model->diversity_of__competitors ?></td>
               
                
                </div>
                <div class="col-md-4">
                
                <th>Product Differenciation</th>
                    <td><?= $model->product_differenciation_substitutes ?></td>
                  
                </div>
                </tr>
                <tr>
                
           <div class="col-md-4">

       
         
           
          
                  
                    <th>Economics Of Scale</th>
                    <td><?= $model->economics_of_scale ?></td>
                    
                   
         
                </div>
                <div class="col-md-4">
           
                    <th>Customer Loyality</th>
                    <td><?= $model->customer_loyality ?></td>
                
                </div>
                <div class="col-md-4">
                
          
                    <th>Customer Switching Cost</th>
                    <td><?= $model->customer_switching_cost ?></td>
                </div>
                </tr>
                <tr>
           <div class="col-md-4">
         
<th>Industry / Sector Growth </th>
                    <td><?= $model->industry_sector_growth ?></td>
</div>

                </tr>
                </tbody>
            </table>
        </div>
</div>
</div>

<div class="row">
<div class="col-md-12">
<div class="panel panel-default">
            <div class="panel-heading">
            Threat of Susbstitutes 
            </div>
            <table class="table" style="table-layout:fixed;">
                <tbody>
                <tr>
           <div class="col-md-4">

                    <th>Availability of Susbstitutes</th>
                    <td><?= $model->availability_of_subsitutes ?></td>
                 
         
                </div>
                <div class="col-md-4">
                
                    <th>Substitute Price v/s Industry Product</th>
                    <td><?= $model->subsitute_price_vs_industry_product ?></td>
               
                
                </div>
                <div class="col-md-4">
                
                <th>Susbstitute Product Quality v/s Industry Product</th>
                    <td><?= $model->subsitute_product_quality_vs_indistry_product ?></td>
                  
                </div>
                </tr>
                <tr>
                
           <div class="col-md-4">

       
         
           
          
                  
                    <th>Switching Costs</th>
                    <td><?= $model->economics_of_scale ?></td>
                    
                   
         
                </div>
           
                </tr>
             
                </tbody>
            </table>
        </div>
</div>

</div>
<div class="row">
<div class="col-md-12">
<div class="panel panel-default">
            <div class="panel-heading">
            Threat of New Entrants 


            </div>
            <table class="table" style="table-layout:fixed;">
                <tbody>
                <tr>
           <div class="col-md-4">
      
           
                    <th>Specialist Knowledge </th>
                    <td><?= $model->specialist_knowledge ?></td>
                 
         
                </div>
                <div class="col-md-4">
                
                    <th>Product Differenciation</th>
                    <td><?= $model->product_differenciation ?></td>
               
                
                </div>
                <div class="col-md-4">
                
                <th>Brand names in the industry are not well-known</th>
                    <td><?= $model->brand_name ?></td>
                  
                </div>
                </tr>
                <tr>
                
           <div class="col-md-4">
         <th>Initial capital investment </th>
                    <td><?= $model->initial_capital_investment ?></td>
                    
                   
         
                </div>
                <div class="col-md-4">
           
                    <th>Consumer switching costs</th>
                    <td><?= $model->consumer_switching_costs ?></td>
                
                </div>
                <div class="col-md-4">
                
          
                    <th>Access To Distribution Channels </th>
                    <td><?= $model->access_to_distribution_channels ?></td>
                </div>
                </tr>
                <tr>
           <div class="col-md-4">
     
<th>Technology Protections 
</th>
                    <td><?= $model->technology_protections ?></td>
</div>
<div class="col-md-4">
       
<th>Governmental & Legal Barries </th>
                    <td><?= $model->governmental_and_legal_barries ?></td>
</div>
<div class="col-md-4">
        
<th>Retaliation (Actual or Threatened) </th>
                    <td><?= $model->retaliation ?></td>
</div>

                </tr>
                </tbody>
            </table>
        </div>
</div>
</div>
<?php
