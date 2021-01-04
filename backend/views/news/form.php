<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 2/27/2019
 * Time: 10:26 AM
 */

use backend\controllers\NewsController;
use backend\widgets\FileSelector;
use cnd\admin\models\activerecords\Setting;
use cnd\filemanager\widgets\MediaInput;
use cnd\form\ActiveForm;
use common\models\News;
use yii\helpers\Html;
use yii\web\View;
use mihaildev\ckeditor\CKEditor;

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
