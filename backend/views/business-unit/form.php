<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 1/29/2019
 * Time: 9:40 AM
 */

use backend\controllers\BusinessUnitController;
use cnd\filemanager\widgets\MediaInput;
use cnd\form\ActiveForm;
use common\models\BusinessUnit;
use yii\helpers\Html;
use yii\web\View;

$view = $this;
$context = $this->context;

assert($view instanceof View);
assert($model instanceof BusinessUnit);
assert($context instanceof BusinessUnitController);

$isNew = $model->isNewRecord;

$this->title = ($isNew?'Add New':'Update').' Business Unit';

$form = ActiveForm::begin(['id' => Yii::$app->controller->id.'-form']);

?>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Information</div>
                <div class="panel-body">
                    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
                    <?= $form->field($model, 'name')->textInput() ?>
                    <?= $form->field($model, 'type')->dropDownList((new BusinessUnit())->type_list) ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Image</div>
                <div class="panel-body">
                    <?=
                    MediaInput::widget([
                        'model' => $model,
                        'attr' => 'image',
                        'title' => false,
                        'count' => 1,
                    ])
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group text-center">
        <?= Html::submitButton($isNew?'Create':'Save', ['class' => 'btn btn-primary btn-lg']) ?>
    </div>

<?php
ActiveForm::end();
