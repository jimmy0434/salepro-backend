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
use cnd\form\ActiveForm;
use common\models\MarketResearch;
use common\models\Portfolio;
use yii\helpers\Html;
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
                    <?= $form->field($model, 'country')->dropDownList(Yii::$app->countries()) ?>
                    <?= $form->field($model, 'region')->textInput() ?>
                    <?= $form->field($model, 'year')->textInput() ?>
                    <?= $form->field($model, 'source')->textInput() ?>
                    <?= $form->field($model, 'product_id')->dropDownList(Portfolio::listData(Portfolio::TARGET_PRODUCT)) ?>
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
                        'ext' => 'xlsx,pdf,pptx',
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
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
