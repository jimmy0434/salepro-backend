<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 2/4/2019
 * Time: 3:00 PM
 */

use backend\controllers\SustainabilityController;
use backend\widgets\FileSelector;
use cnd\admin\models\activerecords\Setting;
use cnd\filemanager\widgets\MediaInput;
use cnd\form\ActiveForm;
use common\models\Sustainability;
use yii\helpers\Html;
use yii\web\View;

$view = $this;
$context = $this->context;

assert($view instanceof View);
assert($model instanceof Sustainability);
assert($context instanceof SustainabilityController);

$isNew = $model->isNewRecord;

$this->title = ($isNew?'Add New':'Update').' Sustainability';

$form = ActiveForm::begin(['id' => Yii::$app->controller->id.'-form']);

?>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Information</div>
                <div class="panel-body">
                    <?=
                    MediaInput::widget([
                        'model' => $model,
                        'attr' => 'image',
                        'title' => 'Image',
                        'count' => 1,
                    ])
                    ?>
                    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
                    <?= $form->field($model, 'type')->hiddenInput()->label(false) ?>
                    <?= $form->field($model, 'name')->textInput() ?>
                    <?= $form->field($model, 'position')->textInput(['type'=>'number','min'=>0]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">File</div>
                <div class="panel-body">
                    <?= FileSelector::widget([
                        'model' => $model,
                        'property' => 'file_id',
                        'title' => "File",
                        'fileName' => uniqid('sustainability-'.$this->context->type.'-', true),
                        'ext' => Setting::get('sustainability.'.$this->context->type.'.extensions','pdf,pptx,ppt'),
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group text-center">
        <?= Html::submitButton($isNew?'Create':'Save', ['class' => 'btn btn-primary btn-lg']) ?>
    </div>

<?php
ActiveForm::end();
