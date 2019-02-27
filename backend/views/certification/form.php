<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 2/27/2019
 * Time: 10:26 AM
 */

use backend\controllers\CertificationController;
use backend\widgets\FileSelector;
use cnd\admin\models\activerecords\Setting;
use cnd\filemanager\widgets\MediaInput;
use cnd\form\ActiveForm;
use common\models\Certification;
use yii\helpers\Html;
use yii\web\View;

$view = $this;
$context = $this->context;

assert($view instanceof View);
assert($model instanceof Certification);
assert($context instanceof CertificationController);

$isNew = $model->isNewRecord;

$this->title = ($isNew ? 'Add New' : 'Update') . ' Certification';

$form = ActiveForm::begin(['id' => Yii::$app->controller->id . '-form']);

?>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Information</div>
                <div class="panel-body">
                    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
                    <?=
                    MediaInput::widget([
                        'model' => $model,
                        'attr' => 'image',
                        'title' => false,
                        'count' => 1,
                    ])
                    ?>
                    <?= $form->field($model, 'name')->textInput() ?>
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
                        'fileName' => uniqid('certification-', true),
                        'ext' => Setting::get('certification.extensions', 'pdf'),
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
