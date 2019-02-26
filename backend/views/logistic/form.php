<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 2/25/2019
 * Time: 3:21 PM
 */

use backend\controllers\LogisticController;
use backend\widgets\FileSelector;
use cnd\admin\models\activerecords\Setting;
use cnd\filemanager\widgets\MediaInput;
use cnd\form\ActiveForm;
use common\models\Logistic;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\web\View;

$view = $this;
$context = $this->context;

assert($view instanceof View);
assert($model instanceof Logistic);
assert($context instanceof LogisticController);

$isNew = $model->isNewRecord;

$this->title = ($isNew ? 'Add New' : 'Update') . ' Logistic :: '.$context->categories[$context->category];

$categoryKey = Inflector::slug($context->categories[$context->category]);

$form = ActiveForm::begin(['id' => Yii::$app->controller->id . '-form']);
?>
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Information</div>
                <div class="panel-body">
                    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
                    <?= $form->field($model, 'category_id')->hiddenInput()->label(false) ?>
                    <?= $form->field($model, 'name')->textInput() ?>
                    <?= $form->field($model, 'position')->textInput() ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
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
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">File</div>
                <div class="panel-body">
                    <?= FileSelector::widget([
                        'model' => $model,
                        'property' => 'file_id',
                        'title' => "File",
                        'fileName' => uniqid('logistics-'.$categoryKey.'-', true),
                        'ext' => Setting::get('logistics.'.$categoryKey.'.extensions','pdf,pptx,ppt'),
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
