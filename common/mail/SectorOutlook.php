<?php

use yii\helpers\Html;
use common\mail\mime;

/* @var $this yii\web\View */
/* @var $competitor common\models\Competitor */

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
                        if ($SectorOutlook->businessUnit && $SectorOutlook->businessUnit->portfolio) {
                            echo $SectorOutlook->businessUnit->portfolio->name;
                        } else {
                            echo $na;
                        }
                        ?>
                    </td>
                </tr>
                    <tr>
                        <th>Sector</th>
                        <td><?= $SectorOutlook->name ?></td>
                    </tr>
                  
                    <tr>
                        <th>Salesman</th>
                        <td>
                            <?php
                            if ($SectorOutlook->salesman) {
                                echo $SectorOutlook->salesman->name;
                            } else {
                                echo $na;
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Industry</th>
                        <td><?= $SectorOutlook->industry ?? $na ?></td>
                    </tr>
                    <tr>
                        <th>Country</th>
                        <td><?= $SectorOutlook->country ?? $na ?></td>
                    </tr>
                    <tr>
                        <th>Outlook</th>
                        <td><?= $SectorOutlook->outlook ?? $na ?></td>
                    </tr>
                    <tr>
                        <th>Source</th>
                        <td><?= $SectorOutlook->source ?? $na ?></td>
                    </tr>
                  
                    <tr>
                        <th>Growth Rate %</th>
                        <td><?= $SectorOutlook->growth_rate ?? $na ?></td>
                    </tr>
                      
                    </tbody>
                </table>
            </div>
        </div>
     </div>
    </div>
<?php
