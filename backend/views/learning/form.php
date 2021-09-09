<?php


use backend\controllers\LearningController;
use backend\widgets\AutoCompleteInput;
use backend\widgets\FileSelector;
use cnd\admin\models\activerecords\Setting;
use cnd\filemanager\widgets\MediaInput;
use cnd\form\ActiveForm;
use common\models\Learning;
use yii\helpers\Html;
use yii\web\View;
use mihaildev\ckeditor\CKEditor;
use yii\jui\DatePicker;

$view = $this;
$context = $this->context;

assert($view instanceof View);
assert($model instanceof Learning);
assert($context instanceof LearningController);

$isNew = $model->isNewRecord;

$this->title = ($isNew ? 'Add New' : 'Update') . ' Learning';

$form = ActiveForm::begin(['id' => Yii::$app->controller->id . '-form']);

?>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Information</div>
                <div class="panel-body">
                    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
                  
                    
                    <?= $form->field($model, 'name')->textInput() ?>
                 
                    <?php
                    if (in_array($context->target, [Learning::TARGET_View2])) { ?>
                 
                        <?= $form->field($model, 'parent_id')->dropDownList(Learning::dropDownList(Learning::TARGET_View1)) ?>
                        <?php    
                    }
                   ?>

                   
<?php
                    if (in_array($context->target, [Learning::TARGET_Items]))  { ?>
                 
                        <?= $form->field($model, 'parent_id')->dropDownList(Learning::dropDownList(Learning::TARGET_View2)) ?>
                        <?php    
                    }
                   ?>


                  
              
                  
                </div>
            </div>
        </div>
        <div class="col-md-6">
        <div class="panel panel-default">
                <div class="panel-heading">image</div>
                <div class="panel-body">
                <?=
                    MediaInput::widget([
                        'model' => $model,
                        'attr' => 'image',
                        'title' => false,
                        'count' => 1,
                    ])
                    ?>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Attachment File</div>
                <div class="panel-body">
                <?= FileSelector::widget([
                        'model' => $model,
                        'property' => 'file_id',
                        'title' => false,
                        'fileName' => uniqid('Learning-file-', true),
                        'ext' => Setting::get('Learning.attachment.extensions', 'xlsx,xls,pdf,pptx,ppt'),
                       
                        
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
