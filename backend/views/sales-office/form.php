<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 2/4/2019
 * Time: 3:21 PM
 */

use backend\controllers\SalesOfficeController;
use cnd\form\ActiveForm;
use backend\widgets\FileSelector;
use common\models\DataList;
use common\models\SalesOffice;
use yii\helpers\Html;
use yii\web\View;
use cnd\admin\models\activerecords\Setting;
use cnd\filemanager\widgets\MediaInput;
use yii\helpers\Inflector;



$view = $this;
$context = $this->context;

assert($view instanceof View);
assert($model instanceof SalesOffice);
assert($context instanceof SalesOfficeController);

$isNew = $model->isNewRecord;

$this->title = ($isNew ? 'Add New' : 'Update') . ' Sales Office';

$form = ActiveForm::begin(['id' => Yii::$app->controller->id . '-form']);

?>
    <div class="panel panel-default">
        <div class="panel-heading">Information</div>
        <div class="panel-body">
            <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
            <?= $form->field($model, 'name')->textInput() ?>
            <?php //echo $form->field($model, 'position')->textInput(['type' => 'number', 'min' => 0]); ?>
            <?= $form->field($model, 'region')->dropDownList(DataList::dropDownList(DataList::TYPE_REGION)) ?>
            <?= $form->field($model, 'content')->editorInput() ?>
        </div>
        <div class="panel-heading">File</div>
                <div class="panel-body">
                    <?= FileSelector::widget([
                        'model' => $model,
                        'property' => 'file_id',
                        'title' => "File",
                        'fileName' => uniqid('sales-offices-', true),
                        'ext' => Setting::get('sales-offices.extensions','jpg,pdf,pptx,ppt'),
                     
                     
                    ]) ?>
                </div>
    </div>
    
    <div class="form-group text-center">
        <?= Html::submitButton($isNew ? 'Create' : 'Save', ['class' => 'btn btn-primary btn-lg']) ?>
    </div>

<?php
ActiveForm::end();
