<?php


use backend\controllers\SteepController;
use backend\widgets\AutoCompleteInput;
use backend\widgets\FileSelector;
use cnd\admin\models\activerecords\Setting;
use cnd\filemanager\widgets\MediaInput;
use cnd\form\ActiveForm;
use common\models\Steep;
use yii\helpers\Html;
use yii\web\View;
use mihaildev\ckeditor\CKEditor;
use yii\jui\DatePicker;

$view = $this;
$context = $this->context;

assert($view instanceof View);
assert($model instanceof Steep);
assert($context instanceof SteepController);

$isNew = $model->isNewRecord;

$this->title = ($isNew ? 'Add New' : 'Update') . ' Steep';

$form = ActiveForm::begin(['id' => Yii::$app->controller->id . '-form']);

?>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Information</div>
                <div class="panel-body">
                    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
                  
                    
                    <?= $form->field($model, 'name')->textInput() ?>
                    <?= $form->field($model, 'url')->textInput() ?>
                
 

                  
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Attachment File</div>
                <div class="panel-body">
                <?= FileSelector::widget([
                        'model' => $model,
                        'property' => 'file_id',
                        'title' => false,
                        'fileName' => uniqid('steep-file-', true),
                        'ext' => Setting::get('steep.attachment.extensions', 'xlsx,xls,pdf,pptx,ppt'),
                       
                        
                    ]) ?>

              
                </div>
            </div>
            
         
        </div>
    </div>
    <div class="form-group text-center">
        <?= Html::submitButton($isNew ? 'Create' : 'Save', ['class' => 'btn btn-primary btn-lg']) ?>
    </div>

<?php
ActiveForm::end();
