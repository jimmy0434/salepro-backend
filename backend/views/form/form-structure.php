<?php
/**
 * Created by PhpStorm.
 * User: Jawdat Sobh
 * Date: 11/15/2018
 * Time: 2:49 PM
 *
 * @var $this View
 * @var $model Form
 * @var $context FormController
 */

use backend\controllers\FormController;
use common\models\Form;
use yii\web\View;
use yii\web\JqueryAsset;

$this->title = "Manage Form Structure";
?>
    <div id="form-builder">
        <div class="row">
            <div class="col-md-8">
                <form-Item :structure="options.form.structure"></form-Item>
            </div>
            <div class="col-md-4">

            </div>
        </div>
    </div>
    <script type="text/x-template" id="form-item">
        <div class="form-item">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 style="margin:0;padding:0;" class="pull-left">{{list.name}}</h3>
                    <div class="btn-group pull-right">
                        <button type="button" class="btn btn-danger">Fields</button>
                        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li v-for="(name, label, index) in types" v-bind:key="'type-'+label">
                                <a href="#" @click="addField(name)">
                                    Add new <strong>{{label | typeName}}</strong> field
                                </a>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li>
                                <a href="#" @click="addField(separator)">
                                    Add new <strong>{{separator | typeName}}</strong> field
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <div v-for="(field, index) in list.fields" class="form-horizontal">
                        <div v-if="field === separator" style="height:2px;background:#555;"></div>
                        <div class="form-group" v-if="field !== separator">
                            <label class="col-sm-2 control-label">Label</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Label" v-model="field.label">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </script>
<?php
/**
 * @var $id int
 * @var $name string
 * @var $title string
 * @var $status int
 * @var $content_id int
 * @var $version int
 * @var $structure string
 * @var $created_at string
 * @var $updated_at string
 */
$form = \yii\helpers\Json::encode($model->attributes);
$ready = <<< JS
formBuilder('#form-builder', {
    form: $form
});
JS;
$this->registerJsFile(Yii::$app->helper->getAssetUrl('@npm/vue/dist/vue' . (YII_ENV_DEV ? '' : '.min') . '.js'), [
    'depends' => JqueryAsset::className(),
]);
$this->registerJsFile(Yii::$app->helper->getAssetUrl('@backend/assets/dist/js/form-builder.js'), [
    'depends' => JqueryAsset::className(),
]);
$this->registerJs($ready);

