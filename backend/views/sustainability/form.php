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
                    <?= $form->field($model, 'name')->textInput() ?>
                    <?= $form->field($model, 'url')->textInput() ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Files</div>
                <div class="panel-body">
                    <?= FileSelector::widget([
                        'model' => $model,
                        'property' => 'power_point',
                        'title' => "Power Point",
                        'fileName' => uniqid('sustainability-ppt-', true),
                        'ext' => Setting::get('sustainability.powerpoint.extensions','pptx,ppt'),
                    ]) ?>
                    <?= FileSelector::widget([
                        'model' => $model,
                        'property' => 'brochure',
                        'title' => "Brochure",
                        'fileName' => uniqid('sustainability-brochure-', true),
                        'ext' => Setting::get('sustainability.brochure.extensions','pdf'),
                    ]) ?>
                    <?= FileSelector::widget([
                        'model' => $model,
                        'property' => 'video',
                        'title' => "Video",
                        'fileName' => uniqid('sustainability-video-', true),
                        'ext' => Setting::get('sustainability.video.extensions','mp4'),
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
