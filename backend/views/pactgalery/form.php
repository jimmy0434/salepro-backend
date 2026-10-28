<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 1/29/2019
 * Time: 8:43 AM
 */

use backend\controllers\PactgaleryController;
use backend\widgets\AutoCompleteInput;
use cnd\form\ActiveForm;
use common\models\BusinessUnit;
use common\models\Pactgalery;
use yii\helpers\Html;
use yii\web\View;
use yii\jui\DatePicker;
use backend\widgets\FileSelector;
use cnd\admin\models\activerecords\Setting;
use cnd\filemanager\widgets\MediaInput;

$view = $this;
$context = $this->context;

assert($view instanceof View);
assert($model instanceof Pactgalery);
assert($context instanceof PactgaleryController);


$isNew = $model->isNewRecord;

$this->title = ($isNew ? 'Add New' : 'Update') . ' Pact Galery';

$form = ActiveForm::begin(['id' => Yii::$app->controller->id . '-form']);

?>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Information</div>         
               
                    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
                    <?= $form->field($model, 'name')->textInput() ?>
                   
                </div>
            </div>
        </div>
        <div class="col-md-6">
        <div class="panel panel-default">
                <div class="panel-heading">File</div>
                <div class="panel-body">
                    <?= FileSelector::widget([
                        'model' => $model,
                        'property' => 'file_id',
                        'title' => 'File',
                        'fileName' => uniqid('pactgalery-file-', true),
                        'ext' => Setting::get('pactgalery.attachment.extensions', 'xlsx,xls,pdf,pptx,ppt'),
                    ]) ?>
                   
                </div>
            </div>
            <div class="panel panel-default">
               
               
        </div>
      
    
    <div class="form-group text-center">
        <?= Html::submitButton($isNew ? 'Create' : 'Save', ['class' => 'btn btn-primary btn-lg']) ?>
    </div>

<?php
ActiveForm::end();
