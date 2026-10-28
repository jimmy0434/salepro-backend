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
                $dateTime = date('Y-m-d H:i:s', $Rdr->created_at);
                ?>
                
                <tr>
                    <th>Reference Number</th>
                    <td><?= $Rdr->reff ?? $na ?></td>
                </tr>
                <tr>
                    <th>Contact Person</th>
                    <td><?php
                        if ($Rdr->salesman) {
                            echo $Rdr->salesman->name;
                        } else {
                            echo $na;
                        }
                        ?></td>
                    <th>Date</th>
                    <td><?= $dateTime ?></td>
                </tr>
                <tr>
                    <th>Company</th>
                    <td><?= $Rdr->bu ?></td> 
                    <th>Email</th>
                    <td><?php
                        if ($Rdr->salesman) {
                            echo $Rdr->email;
                        } else {
                            echo $na; 
                        }
                        ?></td>
                </tr>
                <tr>
                    <th>Rdr Type</th>
                    <td><?= $Rdr->type ?? $na ?></td>
                </tr>
                <tr>
                    <th>Subject</th>
                    <td><?= $Rdr->subject ?? $na ?></td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td><?= $Rdr->description ?? $na ?></td>
                </tr>
                
                <tr>
                    <th>Objectives</th>
                    <td><?= $Rdr->objectives ?? $na ?></td>
                </tr>
                
                <tr>
                    <th>Impact</th>
                    <td><?= $Rdr->impact ?? $na ?></td>
                </tr>
                </tbody>
            </table>
