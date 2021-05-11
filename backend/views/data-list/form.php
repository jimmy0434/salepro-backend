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
    const TYPE_PAYMENT_FACILITY = 18;
    if (in_array($context->type, [DataList::TYPE_LEAD_TIME,DataList::TYPE_TIMELY_DELIVERY,DataList::TYPE_CUSTOMER_RELATIONSHIP,DataList::TYPE_QUALITY,DataList::TYPE_PROBLEM_SOLVING_RESPONSE,DataList::TYPE_BRAND_EQUITY,Datalist::TYPE_SINGLE_TEXT,DataList::TYPE_PAYMENT_FACILITY,DataList::TYPE_FIVE_FORCES_NUMBER_OF_SUPPLIERS,DataList::TYPE_FIVE_FORCES_SUPPLIERS_LOCATION,DataList::TYPE_FIVE_FORCES_AVERAGE_SIZE_OF_MAIN_SUPPLIERS,DataList::TYPE_FIVE_FORCES_UNIQUENESS_OF_SERVICE,DataList::TYPE_FIVE_FORCES_NUMBER_OF_BUYERS,DataList::TYPE_FIVE_FORCES_CONCENTRATION_OF_BUYERS,DataList::TYPE_FIVE_FORCES_BUYERS_SIZE_OF_ORDERS,DataList::TYPE_FIVE_FORCES_NUMBER_OF_COMPETITORS,DataList::TYPE_FIVE_FORCES_INDUSTRY_SECTOR_GROWTH,DataList::TYPE_FIVE_FORCES_SUBSITUTE_PRICE_VS_INDUSTRY,DataList::TYPE_FIVE_FORCES_SUBSITUTE_PRODUCT_QUALITY_VS_INDUSTRY,DataList::TYPE_FIVE_FORCES_TREAT_BRAND_NAME,DataList::TYPE_FIVE_FORCES_ACCESS_TO_DISTRIBUTION_CHANNELS,DataList::TYPE_FIVE_FORCES_AVERAGE_ASC,DataList::TYPE_FIVE_FORCES_AVERAGE_DESC]))
     {
                
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
