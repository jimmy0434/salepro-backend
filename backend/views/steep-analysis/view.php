<?php


use backend\controllers\SteepAnalysisController;
use common\models\SteepAnalysis;
use yii\helpers\Html;
use yii\web\View;

$view = $this;
$context = $this->context;

assert($view instanceof View);
assert($context instanceof SteepAnalysisController);

$this->title = $model->name . ' Analysis';

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
                    <th>Name</th>
                    <td><?= $model->name ?></td>
                </tr>
                <tr>
                    <th>Category</th>
                    <td><?= $model->category ?></td>
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
                <th>Subsequent</th>
                        <td><?= $model->subsequent ?? $na ?></td>
                    </tr>
                    <tr>
                        <th>Impact</th>
                        <td><?= $model->impact ?? $na ?></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td><?= $model->trend_status ?? $na ?></td>
                    </tr>
                    <tr>
                        <th>Risk Category</th>
                        <td><?= $model->risk_category ?? $na ?></td>
                    </tr>
                    <tr>
                        <th>Control Measure</th>
                        <td><?= $model->control_measure ?? $na ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    </div>
</div>
<?php
