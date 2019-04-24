<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 4/24/2019
 * Time: 9:26 AM
 */

use backend\controllers\GroupController;
use cnd\form\ActiveForm;
use common\models\DataList;
use common\models\Group;
use yii\helpers\Html;
use yii\web\View;

$view = $this;
$context = $this->context;

assert($view instanceof View);
assert($model instanceof Group);
assert($context instanceof GroupController);

$isNew = $model->isNewRecord;

$this->title = ($isNew ? 'Add New' : 'Update') . ' Group';

$form = ActiveForm::begin(['id' => Yii::$app->controller->id . '-form']);

?>
    <div class="panel panel-default">
        <div class="panel-heading">Information</div>
        <div class="panel-body">
            <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
            <?= $form->field($model, 'name')->textInput() ?>
        </div>
    </div>
    <div class="form-group text-center">
        <?= Html::submitButton($isNew ? 'Create' : 'Save', ['class' => 'btn btn-primary btn-lg']) ?>
    </div>

<?php
ActiveForm::end();
