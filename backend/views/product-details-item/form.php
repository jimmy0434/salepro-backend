<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 2/6/2019
 * Time: 9:57 AM
 */

use backend\controllers\ProductDetailsItemController;
use backend\widgets\FileSelector;
use cnd\admin\models\activerecords\Setting;
use cnd\filemanager\widgets\MediaInput;
use cnd\form\ActiveForm;
use common\models\Product;
use common\models\ProductDetail;
use common\models\ProductDetailItem;
use yii\helpers\Html;
use yii\web\View;

$view = $this;
$context = $this->context;
$product = $context->product;
$detail = $context->detail;

assert($view instanceof View);
assert($model instanceof ProductDetailItem);
assert($context instanceof ProductDetailsItemController);
assert($product instanceof Product);
assert($detail instanceof ProductDetail);

$isNew = $model->isNewRecord;

$this->title = ($isNew ? 'Add New' : 'Update') . ' Product Details Content';

$this->params['breadcrumbs'][] = ['label' => "Products", 'url' => ['/portfolio/index', 't' => $context->target]];
$this->params['breadcrumbs'][] = ['label' => $product->portfolio->name, 'url' => ['/product-details/index', 't' => $context->target, 'p' => $product->id]];
$this->params['breadcrumbs'][] = ['label' => $detail->section_label . ' / ' . $detail->title, 'url' => ['/product-details-item/index', 't' => $context->target, 'p' => $product->id, 'd' => $detail->id]];

$form = ActiveForm::begin(['id' => Yii::$app->controller->id . '-form']);

?>
    <div class="panel panel-default">
        <div class="panel-heading">Information</div>
        <div class="panel-body">
            <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
            <?= $form->field($model, 'product_detail_id')->hiddenInput()->label(false) ?>
            <?= $form->field($model, 'type')->hiddenInput()->label(false) ?>
            <?= $form->field($model, 'title')->textInput() ?>
            <?php
            if ($model->type == ProductDetailItem::TYPE_FILE) {
                echo FileSelector::widget([
                    'model' => $model,
                    'property' => 'file_id',
                    'title' => "File",
                    'fileName' => uniqid('product-details-file-', true),
                    'ext' => Setting::get('product.details.extensions', 'xlsx,xls,pdf,ppt,pptx,doc,docx'),
                ]);
            }else if($model->type == ProductDetailItem::TYPE_CONTENT){
                echo $form->field($model, 'text')->editorInput();
                echo MediaInput::widget([
                    'model' => $model,
                    'attr' => 'image',
                    'title' => 'Image',
                    'count' => 1,
                ]);
            }
            ?>
        </div>
    </div>
    <div class="form-group text-center">
        <?= Html::submitButton($isNew ? 'Create' : 'Save', ['class' => 'btn btn-primary btn-lg']) ?>
    </div>

<?php
ActiveForm::end();
