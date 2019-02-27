<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 2/27/2019
 * Time: 4:08 PM
 */

use backend\widgets\FileSelector;
use cnd\admin\models\activerecords\Setting;
use cnd\form\ActiveForm;
use yii\helpers\Html;

$this->title = "Marketing Directory";

$form = ActiveForm::begin(['id' => Yii::$app->controller->id . '-form']);
 ?>
<div class="panel panel-default">
    <div class="panel-heading">File</div>
    <div class="panel-body">
        <?= FileSelector::widget([
            'model' => $model,
            'property' => 'id',
            'title' => "Marketing Directory File",
            'fileName' => uniqid('marketing.directory-', true),
            'ext' => Setting::get('marketing.directory.extensions', 'xls,xlsx'),
        ]) ?>
    </div>
    <div class="panel-footer">
        <div class="form-group text-center">
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
</div>
<?php
ActiveForm::end();
