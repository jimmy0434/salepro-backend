<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 2/6/2019
 * Time: 4:03 PM
 */

use backend\controllers\DataListController;
use cnd\form\ActiveForm;
use common\models\DataList;
use yii\helpers\Html;
use yii\web\View;
use cnd\filemanager\widgets\MediaInput;
use backend\widgets\AutoCompleteInput;


$view = $this;
$context = $this->context;

assert($view instanceof View);
assert($model instanceof DataList);
assert($context instanceof DataListController);

$isNew = $model->isNewRecord;

$this->title = ($isNew ? 'Add New' : 'Update') . ' ' . $context->types[$context->type];

$form = ActiveForm::begin(['id' => Yii::$app->controller->id . '-form']);

?>
    <div class="panel panel-default">
        <div class="panel-heading">Information</div>
        <div class="panel-body">
            <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
            <?= $form->field($model, 'parent_id')->hiddenInput()->label(false) ?>
            <?= $form->field($model, 'type')->hiddenInput()->label(false) ?>
            <?= $form->field($model, 'name')->textInput() ?>
            
<?php
            if (in_array($context->type, [DataList::TYPE_LEAD_TIME,DataList::TYPE_TIMELY_DELIVERY,DataList::TYPE_CUSTOMER_RELATIONSHIP,DataList::TYPE_QUALITY,DataList::TYPE_PROBLEM_SOLVING_RESPONSE,DataList::TYPE_BRAND_EQUITY])) {
                
                echo $form->field($model, 'weight')->textInput();

                echo $form->field($model, 'score')->textInput(); 
               
                    
              
            }
                ?>
                
                  
        </div>
    </div>
    <div class="form-group text-center">
        <?= Html::submitButton($isNew ? 'Create' : 'Save', ['class' => 'btn btn-primary btn-lg']) ?>
    </div>

<?php
ActiveForm::end();
