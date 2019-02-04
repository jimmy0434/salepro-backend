<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 1/29/2019
 * Time: 11:22 AM
 */

use backend\controllers\MarketResearchController;
use backend\widgets\AutoCompleteInput;
use backend\widgets\FileSelector;
use cnd\admin\models\activerecords\Setting;
use cnd\form\ActiveForm;
use common\models\MarketResearch;
use common\models\Portfolio;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;

$view = $this;
$context = $this->context;

assert($view instanceof View);
assert($model instanceof MarketResearch);
assert($context instanceof MarketResearchController);

$isNew = $model->isNewRecord;

$this->title = ($isNew ? 'Add New' : 'Update') . ' Market Research';

$form = ActiveForm::begin(['id' => Yii::$app->controller->id . '-form']);
?>
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Information</div>
                <div class="panel-body">
                    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
                    <?= $form->field($model, 'sector_id')->dropDownList(Portfolio::listData(Portfolio::TARGET_SECTOR)) ?>
                    <?= $form->field($model, 'name')->textInput() ?>
                    <?= $form->field($model, 'year')->textInput() ?>
                    <?= $form->field($model, 'source')->textInput() ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Products</div>
                <div class="panel-body">
                    <?= AutoCompleteInput::widget([
                        'model' => $model,
                        'form' => $form,
                        'property' => 'productsIds',
                        'findUrl' => ['/portfolio/find-products'],
                        'addUrl' => ['/portfolio/add-product'],
                        'title' => 'Products',
                        'data' => $model->products,
                    ]) ?>
                    <?= $form->field($model, 'countriesNames')->dropDownListAdvanced(Yii::$app->countries(), ['multiple' => true], '{plugins: [\'remove_button\']}') ?>
                    <?= $form->field($model, 'regionsNames')->dropDownListAdvanced(Yii::$app->regions(), ['multiple' => true], '{plugins: [\'remove_button\']}') ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Attachment File</div>
                <div class="panel-body">
                    <?= FileSelector::widget([
                        'model' => $model,
                        'property' => 'file_id',
                        'title' => false,
                        'fileName' => uniqid('market-research-file-', true),
                        'ext' => Setting::get('market-research.attachment.extensions', 'xlsx,xls,pdf,pptx,ppt'),
                    ]) ?>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Search Tags</div>
                <div class="panel-body">
                    <?= AutoCompleteInput::widget([
                        'model' => $model,
                        'form' => $form,
                        'property' => 'tags',
                        'findUrl' => ['/search/find-tags'],
                        'addUrl' => ['/search/add-tag'],
                        'title' => 'Tags',
                        'data' => $model->search ? $model->search->tags : [],
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
