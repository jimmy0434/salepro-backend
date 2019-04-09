<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 4/9/2019
 * Time: 9:45 AM
 *
 * @var $this View
 * @var $model Salesman
 * @var $form \cnd\form\ActiveForm
 */

use cnd\filemanager\widgets\MediaInput;
use common\models\Salesman;
use yii\web\View;

?>
<div class="panel panel-default">
    <div class="panel-heading"><?= 'Extra Information' ?></div>
    <div class="panel-body">
        <?= $form->field($model, 'dob')->dateInput(['autocomplete' => 'off']) ?>
        <?= $form->field($model, 'gender')->dropDownList($model->gender_list) ?>
        <?= $form->field($model, 'phone')->textInput(['autocomplete' => 'off']) ?>
        <?= $form->field($model, 'city')->textInput(['autocomplete' => 'off']) ?>
        <?= $form->field($model, 'address')->textarea(['autocomplete' => 'off']) ?>
    </div>
</div>
