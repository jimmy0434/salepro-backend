<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 2/25/2019
 * Time: 1:44 PM
 */

use backend\widgets\CustomSetting;
use cnd\admin\models\activerecords\Setting;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use cnd\form\ActiveForm;

assert($this instanceof View);
assert($this->context instanceof CustomSetting);
assert($this->context->model instanceof Setting);

$form = ActiveForm::begin(['id' => 'form-setting-value-' . $this->context->model->id,'action' => ['/admin/setting/update']]);
echo $form->field($this->context->model, 'id')->hiddenInput()->label(false);
$fct = $this->context->input;
if ($fct && is_callable($fct)) {
    $options = ['id' => 'form-setting-value-input-'.$this->context->model->id];
    echo $fct($form, $this->context->model, 'value', $options)->label($this->context->title);
} else {
    echo $form->field($this->context->model, 'value')->textInput()->label($this->context->title);
}
?>
    <div class="form-group text-center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
    </div>
<?php
ActiveForm::end();

$id = $this->context->model->id;
$scriptReady = <<< JS
    $(document).on('submit','#form-setting-value-{$id}',function(e){
        e.preventDefault();
        var form = $(this);
        var data = $(this).serialize();
        $.ajax({
            type : form.attr('method'),
            url : form.attr('action'),
            data : data,
            success : function(response){
                form.find(':input').prop('disabled',false);
            },
            beforeSend : function(){
                form.find(':input').prop('disabled',true);
            }
        });
        return false;
    });
JS;
$this->registerJs($scriptReady);
