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
use common\models\DataList;
use common\models\SalesOffice;
use yii\helpers\Html;
use yii\web\View;

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
            <?= $form->field($model, 'region')->dropDownList(DataList::dropDownList(DataList::TYPE_REGION)) ?>
            <?= $form->field($model, 'content')->editorInput() ?>
        </div>
    </div>
    <div class="form-group text-center">
        <?= Html::submitButton($isNew ? 'Create' : 'Save', ['class' => 'btn btn-primary btn-lg']) ?>
    </div>

<?php
ActiveForm::end();
