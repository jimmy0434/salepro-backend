<?php

/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 12/3/2018
 * Time: 11:27 AM
 *
 * @var $this \yii\web\View
 * @var $model FormApprovalUser
 */

use common\models\FormApprovalUser;
use common\widgets\FormPreview;
use yii\helpers\Html;

$this->title = "Review Form `".$model->formApproval->form->title."` requested by `".$model->formApproval->user->name."`";

try{
    echo FormPreview::widget([
        'form' => $model->formApproval->form,
    ]);
}catch(\Throwable $t){

}catch(\Exception $e){

}
?>
    <div class="panel panel-default">
        <div class="panel-body">
            <?php
            echo Html::beginForm();
            ?>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea class="form-control" id="message" name="message" placeholder="Message" style="resize:none;height:200px;"></textarea>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= Html::submitInput('Reject', ['name' => 'action', 'class' => 'btn btn-danger btn-block']) ?>
                </div>
                <div class="col-md-6">
                    <?= Html::submitInput('Accept', ['name' => 'action', 'class' => 'btn btn-success btn-block']) ?>
                </div>
            </div>
            <?php
            echo Html::endForm();
            ?>
        </div>
    </div>
<?php




