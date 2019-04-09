<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 4/9/2019
 * Time: 3:00 PM
 */

use cnd\form\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

$this->title = 'Custom Notification';
$groups = Yii::$app->userGroup->groups;
$users = [];
if (!empty($groups) && is_array($groups)) {
    foreach ($groups as $group) {
        $users[0] = 'Check All';
        if (!empty($group->list) && is_array($group->list)) {
            foreach ($group->list as $userId => $userName) {
                $users[$userId] = $userName;
            }
        }
    }
}

$form = ActiveForm::begin(['id' => Yii::$app->controller->id . '-form']);

?>
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">Message</div>
                <div class="panel-body">
                    <?= $form->field($model, 'message')->editorInput() ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Users</div>
                <div class="panel-body">
                    <?= $form->field($model, 'users')->checkboxList($users, [
                        'encode' => false,
                    ])->label(false) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group text-center">
        <?= Html::submitButton('Send', ['class' => 'btn btn-primary btn-lg']) ?>
    </div>
<?php
ActiveForm::end();

$css = <<< CSS
#notificationform-users.form-control{height:417px !important; overflow-x: hidden; overflow-y: auto;}
#notificationform-users label{
    display:block !important;
    -moz-user-select: none;
    -webkit-user-select: none;
    -ms-user-select: none;
    user-select: none;
    border-bottom:1px solid #eee;
    padding:2px 5px;
    margin-bottom:0 !important;
}
#notificationform-users label:hover, 
#notificationform-users label:focus{
    background:#eee;
}
#notificationform-users label:nth-child(1){
    border-bottom:1px solid #555;
    background:#555;
    color:#fff;
}
CSS;
$this->registerCss($css);

$ready = <<< JS
$('#notificationform-users input[type=checkbox]').on('click', function(){
    let val = parseInt($(this).val());
    if(!val){
        // check/uncheck all
        $('#notificationform-users input[type=checkbox]').prop('checked', $(this).is(':checked'));
    }
});
JS;
$script = <<< JS

JS;
$this->registerJs($ready);
$this->registerJs($script, View::POS_END);


