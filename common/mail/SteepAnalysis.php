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
                    Basic Information
                </div>
                <table class="table" style="table-layout:fixed;">
                    <tbody>
                    <?php
                   
                 
                    ?>
                      <tr>
                    <th>Business Unit</th>
                    <td>
                        <?php
                        if ($SteepAnalysis->businessUnit && $SteepAnalysis->businessUnit->portfolio) {
                            echo $SteepAnalysis->businessUnit->portfolio->name;
                        } else {
                            echo $na;
                        }
                        ?>
                    </td>
                </tr>
                    <tr>
                        <th>Name</th>
                        <td><?= $SteepAnalysis->name ?></td>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td><?= $SteepAnalysis->category ?></td>
                    </tr>
                    <tr>
                        <th>Salesman</th>
                        <td>
                            <?php
                            if ($SteepAnalysis->salesman) {
                                echo $SteepAnalysis->salesman->name;
                            } else {
                                echo $na;
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Subsequent</th>
                        <td><?= $SteepAnalysis->subsequent ?? $na ?></td>
                    </tr>
                    <tr>
                        <th>Impact</th>
                        <td><?= $SteepAnalysis->impact ?? $na ?></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td><?= $SteepAnalysis->trend_status ?? $na ?></td>
                    </tr>
                    <tr>
                        <th>Risk Category</th>
                        <td><?= $SteepAnalysis->risk_category ?? $na ?></td>
                    </tr>
                    <tr>
                        <th>Control Measure</th>
                        <td><?= $SteepAnalysis->control_measure ?? $na ?></td>
                    </tr>
                      
                    </tbody>
                </table>
            </div>
        </div>
     </div>
    </div>
<?php
