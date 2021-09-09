<?php

use yii\helpers\Html;
use common\mail\mime;



$na = "N/A";
$mime = new Mime();

?>

<div class="row">
<div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
             <h2>   Main Information</h2>
                </div>
                <table class="table" style="table-layout:fixed;">
                <tbody>
                <tr>
                    <th>Building Block</th>
                    <td><?= $FiveForces->name ?? $na ?></td>
                </tr>
                <tr>
                    <th>Product Line</th>
                    <td><?= $FiveForces->product_line ?? $na ?></td>
                </tr>
                <tr>
                    <th>Business Unit</th>
                    <td>
                        <?php
                        if ($FiveForces->businessUnit && $FiveForces->businessUnit->portfolio) {
                            echo $FiveForces->businessUnit->portfolio->name;
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
                        if ($FiveForces->salesman) {
                            echo $FiveForces->salesman->name;
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



<div class="row">
<div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                <h2>Suppliers Location</h2>
                </div>
                <table class="table" style="table-layout:fixed;">
                <tbody>
                <tr>
              
                <th>Number Of Suppliers</th>
          <td><?= $FiveForces->number_of_suppliers ??$na ?></td>
                 </tr>
                 <tr>
              
                
                 <th>Suppliers location</th>
                    <td><?= $FiveForces->suppliers_location ??$na ?></td>
               
                </tr>
              <tr>
                
              <th>Average Size of Main Suppliers </th>
                    <td><?= $FiveForces->avg_size_supplier ??$na ?></td>
                  </tr>
          <tr>
                  
          <th>Uniqueness Of Service</th>
                    <td><?= $FiveForces->uniqueness_of_service ?? $na?></td>
                    
               </tr>
               <tr>    
         
               <th>Your Ability To Subsitute</th>
           <td><?= $FiveForces->your_ability_to_Subsitute ?? $na ?></td>
                </tr>
                <tr>
               
                <th>Switching Costs </th>
           <td><?= $FiveForces->switching_costs ??$na ?></td>
       </tr>
      
                </tbody>
            </table>
        </div>
    </div>

</div>



       <div class="row">
<div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
              <h2>  Buyer Power</h2>
                </div>
                <table class="table" style="table-layout:fixed;">
                <tbody>
                <tr>
              
       <th>Number Of Buyers</th>
                    <td><?= $FiveForces->number_of_buyers ?? $na ?></td>
                 </tr>
                 <tr>
              
                
                    <th>Concentration Of Buyers</th>
                    <td><?= $FiveForces->concentration_of_buyers ??$na ?></td>
               
                </tr>
              <tr>
                
                <th>Buyer's Size Of Orders</th>
                    <td><?= $FiveForces->buyers_size_of_orders ??$na ?></td>
                  </tr>
          <tr>
                  
                    <th>Buyer's Switching Costs</th>
                    <td><?= $FiveForces->buyers_switching_costs ??$na?></td>
                    
               </tr>
               <tr>    
         
                    <th>Buyer's Ability To Integrate</th>
                    <td><?= $FiveForces->buyers_ability_to_integrate ??$na ?></td>
                </tr>
                <tr>
               
                    <th>Buyer's Price Sensitivity</th>
                    <td><?= $FiveForces->buyers_price_sensitivity ?? $na ?></td>
       </tr>
       <tr>
                    <th>Importance of the Product in The Buyer's Cost Structure</th>
                    <td><?= $FiveForces->buyers_cost_structure ?? $na ?></td>
        </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

<div class="row">
<div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
              <h2>Competitive Rivalry </h2>
                </div>
                <table class="table" style="table-layout:fixed;">
                <tbody>
                <tr>
                 <th>Number of Competitors</th>
                    <td><?= $FiveForces->number_of_competitors ??$na?></td>
</tr>
<tr>
                    <th>Diversity Of Competitors</th>
                    <td><?= $FiveForces->diversity_of__competitors ??$na ?></td>
     </tr>
<tr>          
                
                <th>Product Differenciation</th>
                    <td><?= $FiveForces->product_differenciation_substitutes ??$na ?></td>
               </tr>
<tr>

                    <th>Economics Of Scale</th>
                    <td><?= $FiveForces->economics_of_scale ??$na ?></td>
                   </tr>
<tr> 
           
                    <th>Customer Loyality</th>
                    <td><?= $FiveForces->customer_loyality ??$na ?></td>
                </tr>
<tr>

   <th>Customer Switching Cost</th>
                    <td><?= $FiveForces->customer_switching_cost ??$na ?></td>
</tr>
<tr>
                
<th>Industry / Sector Growth </th>
      
              <td><?= $FiveForces->industry_sector_growth ??$na ?></td>
</tr>

                </tbody>
            </table>
        </div>
    </div>

</div>


<div class="row">
<div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
              <h2>Threat of Susbstitutes</h2>
                </div>
                <table class="table" style="table-layout:fixed;">
                <tbody>
                <tr>
       <th>Availability of Susbstitutes</th>
                    <td><?= $FiveForces->availability_of_subsitutes ??$na ?></td>
                 
</tr>
<tr>
<th>Substitute Price v/s Industry Product</th>
                    <td><?= $FiveForces->subsitute_price_vs_industry_product ??$na ?></td>
               
</tr>
<tr>
 <th>Susbstitute Product Quality v/s Industry Product</th>
                    <td><?= $FiveForces->subsitute_product_quality_vs_indistry_product ??$na ?></td>
                  
</tr>
<tr>
<th>Switching Costs</th>
                    <td><?= $FiveForces->economics_of_scale ??$na ?></td>
</tr>



                </tbody>
            </table>
        </div>
    </div>

</div>

<div class="row">
<div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
              <h2>Threat of New Entrants </h2>
                </div>
                <table class="table" style="table-layout:fixed;">
                <tbody>
                <tr>
           
                    <th>Specialist Knowledge </th>
                    <td><?= $FiveForces->specialist_knowledge ??$na ?></td>
           </tr>
<tr>      
                
                    <th>Product Differenciation</th>
                    <td><?= $FiveForces->product_differenciation ??$na ?></td>
               </tr>
                <tr>

                
                <th>Brand names in the industry are not well-known</th>
                    <td><?= $FiveForces->brand_name ??$na ?></td>
                  </tr>
<tr>
 <th>Initial capital investment </th>
                    <td><?= $FiveForces->initial_capital_investment ??$na ?></td>
                    
</tr>
<tr>

                    <th>Consumer switching costs</th>
                    <td><?= $FiveForces->consumer_switching_costs ??$na ?></td>
                
</tr>
<tr>
  <th>Access To Distribution Channels </th>
                    <td><?= $FiveForces->access_to_distribution_channels ??$na ?></td>
             
</tr>
    <tr>
   
<th>Technology Protections 
</th>
                    <td><?= $FiveForces->technology_protections ??$na ?></td>
</tr>
<tr>
       
<th>Governmental & Legal Barries </th>
                    <td><?= $FiveForces->governmental_and_legal_barries ??$na ?></td>
</tr>
<tr>
<th>Retaliation (Actual or Threatened) </th>
                    <td><?= $FiveForces->retaliation ??$na ?></td>
</tr>


                </tbody>
            </table>
        </div>
    </div>

</div>
<?php
