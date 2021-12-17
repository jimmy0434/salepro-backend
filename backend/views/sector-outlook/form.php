<?php


use backend\controllers\SectoroutlookController;
use backend\widgets\AutoCompleteInput;
use backend\widgets\FileSelector;
use cnd\admin\models\activerecords\Setting;
use cnd\filemanager\widgets\MediaInput;
use cnd\form\ActiveForm;
use common\models\Sectoroutlook;
use yii\helpers\Html;
use yii\web\View;
use mihaildev\ckeditor\CKEditor;
use yii\jui\DatePicker;

$view = $this;
$context = $this->context;

assert($view instanceof View);
assert($model instanceof Sectoroutlook);
assert($context instanceof SectoroutlookController);

$isNew = $model->isNewRecord;

$this->title = ($isNew ? 'Add New' : 'Update') . ' Sectoroutlook';

$form = ActiveForm::begin(['id' => Yii::$app->controller->id . '-form']);

?>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Information</div>
                <div class="panel-body">
                    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
                
                    
                   <!-- <?= $form->field($model, 'industry')->textInput() ?> -->
                  <!--  <?= $form->field($model, 'country')->textInput() ?> -->
                    <?= $form->field($model, 'outlook')->textarea(['rows' => '6']) ?>
                    <?= $form->field($model, 'source')->textInput() ?>
                    <?= $form->field($model, 'growth_rate')->textInput() ?>
                 


                  
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
        
         
        </div>
    </div>
    <div class="form-group text-center">
        <?= Html::submitButton($isNew ? 'Create' : 'Save', ['class' => 'btn btn-primary btn-lg']) ?>
    </div>

<?php
ActiveForm::end();
