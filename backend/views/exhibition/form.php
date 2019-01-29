<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 1/29/2019
 * Time: 8:43 AM
 */

use backend\controllers\ExhibitionController;
use backend\widgets\FileSelector;
use cnd\form\ActiveForm;
use common\models\BusinessUnit;
use common\models\Exhibition;
use yii\helpers\Html;
use yii\web\View;

$view = $this;
$context = $this->context;

assert($view instanceof View);
assert($model instanceof Exhibition);
assert($context instanceof ExhibitionController);

$isNew = $model->isNewRecord;

$this->title = ($isNew?'Add New':'Update').' Exhibition';

$form = ActiveForm::begin(['id' => Yii::$app->controller->id.'-form']);

?>
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Information</div>
                <div class="panel-body">
                    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
                    <?= $form->field($model, 'name')->textInput() ?>
                    <?= $form->field($model, 'country')->dropDownList(Yii::$app->countries()) ?>
                    <?= $form->field($model, 'region')->textInput() ?>
                    <?= $form->field($model, 'year')->textInput() ?>
                    <?= $form->field($model, 'business_unit_id')->dropDownList(BusinessUnit::listData()) ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Excel File</div>
                <div class="panel-body">
                    <?= FileSelector::widget([
                        'model' => $model,
                        'property' => 'file_id',
                        'title' => false,
                        'fileName' => uniqid('exhibition-excel-', true),
                        'ext' => 'xlsx',
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>
    <div class="form-group text-center">
        <?= Html::submitButton($isNew?'Create':'Save', ['class' => 'btn btn-primary btn-lg']) ?>
    </div>

<?php
ActiveForm::end();
