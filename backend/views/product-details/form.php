<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 2/6/2019
 * Time: 8:54 AM
 */

use backend\controllers\ProductDetailsController;
use cnd\form\ActiveForm;
use common\models\Product;
use common\models\ProductDetail;
use yii\helpers\Html;
use yii\web\View;

$view = $this;
$context = $this->context;
$product = $context->product;

assert($view instanceof View);
assert($model instanceof ProductDetail);
assert($context instanceof ProductDetailsController);
assert($product instanceof  Product);

$isNew = $model->isNewRecord;

$this->title = ($isNew ? 'Add New' : 'Update') . ' Product Details | '.$product->portfolio->name;

$form = ActiveForm::begin(['id' => Yii::$app->controller->id . '-form']);

?>
    <div class="panel panel-default">
        <div class="panel-heading">Information</div>
        <div class="panel-body">
            <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
            <?= $form->field($model, 'product_id')->hiddenInput()->label(false) ?>
            <?= $form->field($model, 'title')->textInput() ?>
            <?= $form->field($model, 'section')->dropDownList($model->section_listtranslate) ?>
        </div>
    </div>
    <div class="form-group text-center">
        <?= Html::submitButton($isNew ? 'Create' : 'Save', ['class' => 'btn btn-primary btn-lg']) ?>
    </div>

<?php
ActiveForm::end();
