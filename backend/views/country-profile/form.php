<?php

use backend\controllers\CountryProfileController;
use backend\widgets\AutoCompleteInput;
use backend\widgets\FileSelector;

use cnd\admin\models\activerecords\Setting;
use cnd\form\ActiveForm;
use common\models\CountryProfile;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;

$view = $this;
$context = $this->context;

assert($view instanceof View);
assert($model instanceof CountryProfile);
assert($context instanceof CountryProfileController);

$isNew = $model->isNewRecord;

$this->title = ($isNew ? 'Add New' : 'Update') . ' Country Profile';

$form = ActiveForm::begin(['id' => Yii::$app->controller->id . '-form']);
?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Information</div>
                <div class="panel-body">
                    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
                    <?= $form->field($model, 'name')->textInput() ?>
                    <?= $form->field($model, 'year')->textInput() ?>

                    <?= $form->field($model, 'countriesNames')->dropDownListAdvanced(Yii::$app->countries(), ['multiple' => true], '{plugins: [\'remove_button\']}') ?>
                    <?= $form->field($model, 'regionsNames')->dropDownListAdvanced(Yii::$app->regions(), ['multiple' => true], '{plugins: [\'remove_button\']}') ?>
             

                </div>
            </div>
        </div>
  
    
    </div>
    
    <div class="panel panel-default">
        <div class="panel-heading"><?= 'Privilege' ?></div>
        <div class="panel-body">
            <?= $model->getPrivilegeForm($form) ?>
        </div>
    </div>
    <div class="form-group text-center">
        <?= Html::submitButton($isNew ? 'Create' : 'Save', ['class' => 'btn btn-primary btn-lg']) ?>
    </div>

<?php
ActiveForm::end();
