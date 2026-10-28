<?php

use yii\helpers\Html;
use common\mail\mime;



$na = "N/A";
$mime = new Mime();

?>
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Technical Assistance Request Form (TARF)
                </div>
                <table class="table" style="table-layout:fixed;">
                    <tbody>
                    <?php
                   
                   $dateTime = date('Y-m-d H:i:s', $Tarf1->created_at);
                    ?>
                      <tr>
                    <th>Reference Number</th>
                    <td><?= $Tarf1->reff ?? $na ?></td>
                </tr>
                    <tr>
                        <th>Contact Person</th>
                        <td><?php
                            if ($Tarf1->salesman) {
                                echo $Tarf1->salesman->name;
                            } else {
                                echo $na;
                            }
                            ?></td>
                             <th>Date</th>
                             <td><?= $dateTime ?></td>
                    </tr>
                    <tr>
                        <th>Company</th>
                        <td><?= $Tarf1->bu ?></td>
                        <th>Email</th>
                        <td><?php
                            if ($Tarf1->salesman) {
                                echo $Tarf1->email;
                            } else {
                                echo $na;
                            }
                            ?></td>
                    </tr>
                    <tr>
                        <th>type</th>
                        <td><?= $Tarf1->type ?? $na ?></td>
                    </tr>
                    <tr>
                        <th>Subject</th>
                        <td><?= $Tarf1->subject ?? $na ?></td>
                    </tr>
                  
                    <tr>
                        <th>Description</th>
                        <td><?= $Tarf1->description ?? $na ?></td>
                    </tr>


                    

                    
                      
                    </tbody>
                </table>
                <table class="table" style="table-layout:fixed;">
                    <tbody>
                    <?php
                   
                 
                    ?>
                     <tr>
    <th>Sample Name</th>
    <th>HS Code</th>
    <th>Sample Type</th>
    <th>Sample Specs</th>
  </tr>

                    <tr>
                <td> Sample 1</td>
                <td><?= $Tarf1->sample_name_1 ?? $na ?></td>
                <td><?= $Tarf1->sample_hs_code_1 ?? $na ?></td>
                <td><?= $Tarf1->sample_type_1 ?? $na ?></td>
                <td><?= $Tarf1->sample_specs_1 ?? $na ?></td>

       
                    </tr>
                    <tr>
                <td> Sample 2</td>
                <td><?= $Tarf1->sample_name_2 ?? $na ?></td>
                <td><?= $Tarf1->sample_hs_code_2 ?? $na ?></td>
                <td><?= $Tarf1->sample_type_2 ?? $na ?></td>
                <td><?= $Tarf1->sample_specs_2 ?? $na ?></td>

       
                    </tr>
                    <tr>
                <td> Sample 3</td>
                <td><?= $Tarf1->sample_name_3 ?? $na ?></td>
                <td><?= $Tarf1->sample_hs_code_3 ?? $na ?></td>
                <td><?= $Tarf1->sample_type_3 ?? $na ?></td>
                <td><?= $Tarf1->sample_specs_3 ?? $na ?></td>

       
                    </tr>
                    <tr>
                <td> Sample 4</td>
                <td><?= $Tarf1->sample_name_4 ?? $na ?></td>
                <td><?= $Tarf1->sample_hs_code_4 ?? $na ?></td>
                <td><?= $Tarf1->sample_type_4 ?? $na ?></td>
                <td><?= $Tarf1->sample_specs_4 ?? $na ?></td>

       
                    </tr>

                      
                    </tbody>
                </table>
            </div>
        </div>
     </div>
    </div>
<?php
