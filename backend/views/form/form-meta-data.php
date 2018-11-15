<?php
/**
 * Created by PhpStorm.
 * User: Jawdat Sobh
 * Date: 11/15/2018
 * Time: 2:37 PM
 *
 * @var $this View
 * @var $model Form
 * @var $context FormController
 */

use backend\controllers\FormController;
use cnd\form\ActiveForm;
use common\models\Form;
use yii\web\View;
use yii\helpers\Html;

$isNew = $model->isNewRecord;

$this->title = ($isNew?'Add New Form':'Manage Form').' Meta Data';
$context = $this->context;

$form = ActiveForm::begin(['id' => Yii::$app->controller->id.'-form']);
?>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading"><?= ucfirst(Yii::$app->controller->id).' Form' ?></div>
                <div class="panel-body">
                    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
                    <?= $form->field($model, 'name')->textInput() ?>
                    <?= $form->field($model, 'title')->textInput() ?>
                    <?= $form->field($model, 'status')->dropDownList($model->status_list) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group text-center">
        <?= Html::submitButton($isNew?'Next':'Save', ['class' => 'btn btn-primary btn-lg']) ?>
    </div>

<?php
ActiveForm::end();
