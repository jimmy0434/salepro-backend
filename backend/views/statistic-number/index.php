<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 2/7/2019
 * Time: 10:09 AM
 *
 * @var $models StatisticNumber[]
 */

use backend\controllers\StatisticNumberController;
use cnd\filemanager\widgets\MediaInput;
use cnd\form\ActiveForm;
use common\models\StatisticNumber;
use yii\helpers\Html;
use yii\web\View;

$view = $this;
$context = $this->context;

assert($view instanceof View);
assert($context instanceof StatisticNumberController);

$this->title = "Statistic Numbers";

$form = ActiveForm::begin([
    'id' => Yii::$app->controller->id . '-form',
    'action' => ['/statistic-number/save'],
]);
if (!empty($models) && is_array($models)) {
    foreach ($models as $i => $model) {
        ?>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3">
                        <?=
                        MediaInput::widget([
                            'model' => $model,
                            'attr' => '[' . $i . ']image',
                            'title' => 'Image',
                            'count' => 1,
                        ])
                        ?>
                    </div>
                    <div class="col-md-9">
                        <?= $form->field($model, '[' . $i . ']id')->hiddenInput()->label(false) ?>
                        <?= $form->field($model, '[' . $i . ']label')->textInput() ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
    <div class="form-group text-center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary btn-lg']) ?>
    </div>
    <?php
}
ActiveForm::end();
