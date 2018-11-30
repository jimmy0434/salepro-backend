<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11/30/2018
 * Time: 12:48 PM
 *
 * @var $this \yii\web\View
 * @var $model \common\models\RoleApproval
 * @var $context \backend\controllers\ApprovalController
 * @var $users array
 */

use cnd\form\ActiveForm;

$context = $this->context;

$this->title = "Role Approval Form";
$userSearchUrl = \yii\helpers\Url::to(['/approval/find-user']);
$usersOptions = <<< JS
    {
        valueField: 'id',
        labelField: 'full_name',
        searchField: 'text',
        create: false,
        options: __OPTIONS__,
        plugins: ['remove_button'],
        render: {
            option: function(item, escape) {
                return '<div>' +
                    '<img src="' + escape(item.url) + '" alt="" style="height:32px;">' +
                    '<span class="title">' +
                        '<span class="name">' + escape(item.full_name) + '</span>' +
                    '</span>' +
                '</div>';
            },
            item: function(item, escape) {
                return '<div>' +
                    '<img src="' + escape(item.url) + '" alt="" style="height:16px; width:16px; display:inline-block;">' +
                    '<span class="title">' +
                        '<span class="name">' + escape(item.full_name) + '</span>' +
                    '</span>' +
                '</div>';
            }
        },
        load: function(query, callback) {
            if (!query.length) return callback();
            $.ajax({
                url: '{$userSearchUrl}',
                type: 'GET',
                dataType: 'json',
                data: {
                    q: query,
                    page_limit: 10
                },
                error: function() {
                    callback();
                },
                success: function(res) {
                    callback(res.items);
                }
            });
        }
    }             
JS;
$users = \yii\helpers\Json::encode($users);
$usersOptions = str_replace('__OPTIONS__',$users,$usersOptions);

$form = ActiveForm::begin(['id' => Yii::$app->controller->id . '-form']);
?>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Role Approval Form</div>
                <div class="panel-body">
                    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
                    <?= $form->field($model, 'type')->dropDownList($model->type_list) ?>
                    <?= $form->field($model, 'users')->dropDownListAdvanced([],['multiple'=>true],$usersOptions) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group text-center">
        <?= \yii\helpers\Html::submitButton('Save', ['class' => 'btn btn-primary btn-lg']) ?>
    </div>
<?php
ActiveForm::end();
