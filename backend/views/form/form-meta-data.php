<?php
/**
 * Created by PhpStorm.
 * User: Jawdat Sobh
 * Date: 11/15/2018
 * Time: 2:37 PM
 *
 * @var $this View
 * @var $model Form
 * @var $context FormController
 */

use backend\controllers\FormController;
use cnd\form\ActiveForm;
use common\models\Form;
use yii\web\View;
use yii\helpers\Html;

$isNew = $model->isNewRecord;

$this->title = ($isNew?'Add New Form':'Manage Form').' Meta Data';
$context = $this->context;

$form = ActiveForm::begin(['id' => Yii::$app->controller->id.'-form']);
?>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading"><?= ucfirst(Yii::$app->controller->id).' Form' ?></div>
                <div class="panel-body">
                    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
                    <?= $form->field($model, 'status')->hiddenInput()->label(false) ?>
                    <?php
                    if($model->isNewRecord){
                        echo $form->field($model, 'name')->textInput();
                    }else{
                        ?>
                        <div class="form-group field-form-name">
                            <label class="control-label" for="form-name">Name</label>
                            <div id="form-name" class="form-control" aria-invalid="false"><?= $model->name ?></div>
                            <div class="help-block"></div>
                        </div>
                        <?php
                    }
                    ?>
                    <?= $form->field($model, 'title')->textInput() ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group text-center">
        <?= Html::submitButton($isNew?'Next':'Save', ['class' => 'btn btn-primary btn-lg']) ?>
    </div>

<?php
ActiveForm::end();
$ready = <<< JS
let autoCreateName = true;
$('#form-name').on('blur', function(){
    autoCreateName = false;
    if($.trim($(this).val()) === ""){
        autoCreateName = true;
    }
});
$('#form-title').on('change input paste', function(){
    if(autoCreateName){
        $('#form-name').val($(this).val().replace(/ /g,"_").toLowerCase());
    }
});
JS;
$this->registerJs($ready);

