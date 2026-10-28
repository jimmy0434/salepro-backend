<?php


use backend\controllers\DirectoryController;
use backend\widgets\AutoCompleteInput;
use backend\widgets\FileSelector;
use cnd\admin\models\activerecords\Setting;
use cnd\filemanager\widgets\MediaInput;
use cnd\form\ActiveForm;
use common\models\Directory;
use yii\helpers\Html;
use yii\web\View;
use mihaildev\ckeditor\CKEditor;
use yii\jui\DatePicker;
use common\models\Sector;

$view = $this;
$context = $this->context;

assert($view instanceof View);
assert($model instanceof Directory);
assert($context instanceof DirectoryController);

$isNew = $model->isNewRecord;

$this->title = ($isNew ? 'Add New' : 'Update') . ' Directory';

$form = ActiveForm::begin(['id' => Yii::$app->controller->id . '-form']);

?>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Information</div>
                <div class="panel-body">
                    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
                   
                    
                    <?= $form->field($model, 'name')->textInput() ?>
                    <?= $form->field($model, 'title')->textInput() ?>
                    <?= $form->field($model, 'phone')->textInput() ?>
                    <?= $form->field($model, 'ext')->textInput() ?>
                    <?= $form->field($model, 'cell')->textInput() ?>
                    <?= $form->field($model, 'email')->textInput() ?>
                    <?= $form->field($model, 'bu')->textInput() ?>
                   
                  
   
 
                  
                </div>
            </div>
        </div>
      
    </div>
    <div class="form-group text-center">
        <?= Html::submitButton($isNew ? 'Create' : 'Save', ['class' => 'btn btn-primary btn-lg']) ?>
    </div>

<?php
ActiveForm::end();
