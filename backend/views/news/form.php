<?php


use backend\controllers\NewsController;
use backend\widgets\AutoCompleteInput;
use backend\widgets\FileSelector;
use common\models\Sector;
use cnd\admin\models\activerecords\Setting;
use cnd\filemanager\widgets\MediaInput;
use cnd\form\ActiveForm;
use common\models\News;
use yii\helpers\Html;
use yii\web\View;
use mihaildev\ckeditor\CKEditor;
use yii\jui\DatePicker;

$view = $this;
$context = $this->context;

assert($view instanceof View);
assert($model instanceof News);
assert($context instanceof NewsController);

$isNew = $model->isNewRecord;

$this->title = ($isNew ? 'Add New' : 'Update') . ' News';

$form = ActiveForm::begin(['id' => Yii::$app->controller->id . '-form']);

?>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Information</div>
                <div class="panel-body">
                    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
                    <?=
                    MediaInput::widget([
                        'model' => $model,
                        'attr' => 'image',
                        'title' => false,
                        'count' => 1,
                    ])
                    ?>
                    
                    <?= $form->field($model, 'title')->textInput() ?>
                   
                   
                    <?= $form->field($model, 'details')->widget(CKEditor::className(),[
                        'editorOptions' => [
                            'preset' => 'full',
                            'inline' => false,
                    
                        ],
                    ]);
                    ?>
  <?= DatePicker::widget([
    'model' => $model,
    'attribute' => 'date',
    'dateFormat' => 'MMM-yyyy',
]) ?>          
    
   

   <?= $form->field($model, 'news_type')->dropDownList(Yii::$app->newstype()) ?>
 

                      <?= $form->field($model, 'sectorsNames')->dropDownListAdvanced(Yii::$app->newssector(), ['multiple' => true], '{plugins: [\'remove_button\']}') ?>

                      <?= $form->field($model, 'tagsNames')->dropDownListAdvanced(Yii::$app->tags(), ['multiple' => true], '{plugins: [\'remove_button\']}') ?>

                      <?= $form->field($model, 'news_steep')->dropDownList(Yii::$app->newssteep()) ?>
       
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Source</div>
                <div class="panel-body">
                <?= $form->field($model, 'source')->textInput() ?>
                <?= $form->field($model, 'url')->textInput() ?>
                <?= $form->field($model, 'source_person')->textInput() ?>


              
                </div>
            </div>
            
         
        </div>
    </div>
    <div class="form-group text-center">
        <?= Html::submitButton($isNew ? 'Create' : 'Save', ['class' => 'btn btn-primary btn-lg']) ?>
    </div>

<?php
ActiveForm::end();
