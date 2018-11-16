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
                <div class="panel panel-default" v-if="item">
                    <div class="panel-heading">
                        <h3 style="margin:0;padding:0;">Properties</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Name" v-model="item.name">
                        </div>
                        <div class="form-group">
                            <label for="label">Label</label>
                            <input type="text" class="form-control" id="label" placeholder="Label" v-model="item.label">
                        </div>
                        <div class="form-group" v-if="item.type === types.TEXT || item.type === types.TEXT_AREA">
                            <label for="placeholder">Placeholder</label>
                            <input type="text" class="form-control" id="placeholder" placeholder="Placeholder"
                                   v-model="item.placeholder">
                        </div>
                        <div class="form-group">
                            <label for="note">Note</label>
                            <input type="text" class="form-control" id="note" placeholder="Note" v-model="item.note">
                        </div>
                        <div class="form-group" v-if="item.type === types.TEXT || item.type === types.TEXT_AREA">
                            <label for="validation">Validation</label>
                            <input type="text" class="form-control" id="validation" placeholder="Validation"
                                   v-model="item.validation">
                        </div>
                        <div class="form-group" v-if="item.type === types.DROP_DOWN_LIST || item.type === types.RADIO">
                            <label>Options</label>
                            <div class="row" v-for="(option, index) in item.options" v-bind:key="'options-'+index"
                                 style="margin-bottom:5px;">
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" placeholder="Value" v-model="option.value">
                                </div>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" placeholder="Label" v-model="option.label">
                                </div>
                                <div class="col-sm-2">
                                    <button class="btn btn-success btn-block" @click="addOption()" v-if="index === 0">
                                        <span class="glyphicon glyphicon-plus"></span>
                                    </button>
                                    <button class="btn btn-danger btn-block" @click="deleteOption(index)"
                                            v-if="index > 0">
                                        <span class="glyphicon glyphicon-minus"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="checkbox"
                             v-if="item.type !== types.CHECKBOX && item.type !== types.RADIO && item.type !== types.DROP_DOWN_LIST">
                            <label>
                                <input type="checkbox" v-model="item.required"> Required
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/x-template" id="form-item">
        <div class="form-item">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 style="margin:0;padding:0;" class="pull-left" v-if="list.isRoot">{{list.name}}</h3>
                    <div class="form-group pull-left" v-if="!list.isRoot" style="margin-left:15px;margin-bottom:0;">
                        <input type="text" class="form-control" id="name" placeholder="Name" v-model="list.name">
                    </div>
                    <div class="btn-group pull-right">
                        <button type="button" class="btn btn-danger">Fields</button>
                        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true"
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
                    <draggable v-model="list.fields" :options="{draggable:'.btn-drag'}">
                        <transition-group>
                            <div v-for="(field, index) in fields" v-bind:key="'field-'+index" class="form-horizontal btn-drag" :data-name="field.name">
                                <div class="col-sm-1">
                                    <button class="btn btn-default btn-block">
                                        <span class="glyphicon glyphicon-move"></span>
                                    </button>
                                </div>
                                <div class="col-sm-10">
                                    <div v-if="field === separator"
                                         style="height:2px;background:rgba(10,10,10,0.5);margin-bottom: 25px;margin-top: 20px;"></div>
                                    <div class="form-group"
                                         v-if="field.type === types.TEXT || field.type === types.TEXT_AREA || field.type === types.DROP_DOWN_LIST"
                                         :data-name="field.name">
                                        <label class="col-sm-2 control-label">
                                            {{field.label}}
                                            <span class="text-danger" v-if="field.required">*</span>
                                        </label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" :placeholder="field.placeholder"
                                                   v-if="field.type === types.TEXT" :required="field.required">
                                            <textarea type="text" class="form-control" :placeholder="field.placeholder"
                                                      v-if="field.type === types.TEXT_AREA"
                                                      :required="field.required"></textarea>
                                            <select class="form-control" v-if="field.type === types.DROP_DOWN_LIST">
                                                <option v-for="(option, index) in field.options" :value="option.value">
                                                    {{option.label}}
                                                </option>
                                            </select>
                                            <p class="help-block" v-if="field.note">{{field.note}}</p>
                                        </div>
                                    </div>
                                    <div class="checkbox" v-if="field.type === types.CHECKBOX" :data-name="field.name"
                                         style="margin:15px 0;">
                                        <label>
                                            <input type="checkbox"> {{field.label}}
                                        </label>
                                        <p class="help-block" v-if="field.note">{{field.note}}</p>
                                    </div>
                                    <div class="form-group radio-list" v-if="field.type === types.RADIO"
                                         :data-name="field.name" style="margin:15px 0;">
                                        <label class="control-label">
                                            {{field.label}}
                                        </label>
                                        <p class="help-block" v-if="field.note">{{field.note}}</p>
                                        <div class="radio" v-for="(option, index) in field.options"
                                             style="padding:0 7px;">
                                            <label>
                                                <input type="radio" name="optionsRadios" id="optionsRadios1"
                                                       v-model="option.value"
                                                       checked>
                                                {{option.label}}
                                            </label>
                                        </div>
                                    </div>
                                    <component is="sub-form-item" :structure="field"
                                               v-if="field.type === types.SUB_FORM" :data-name="field.name"></component>
                                </div>
                                <div class="col-sm-1">
                                    <button class="btn btn-default btn-block" @click="openProperties(field,index)">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </transition-group>
                    </draggable>
                </div>
            </div>
        </div>
    </script>
<?php
$form = \yii\helpers\Json::encode($model->attributes);
$ready = <<< JS
formBuilder('#form-builder', {
    form: $form
});
JS;
$this->registerJsFile(Yii::$app->helper->getAssetUrl('@npm/vue/dist/vue' . (YII_ENV_DEV ? '' : '.min') . '.js'), [
    'depends' => JqueryAsset::className(),
]);
$this->registerJsFile(Yii::$app->helper->getAssetUrl('@backend/assets/dist/js/sortable.min.js'), [
    'depends' => JqueryAsset::className(),
]);
$this->registerJsFile(Yii::$app->helper->getAssetUrl('@backend/assets/dist/js/vuedraggable.min.js'), [
    'depends' => JqueryAsset::className(),
]);
$this->registerJsFile(Yii::$app->helper->getAssetUrl('@backend/assets/dist/js/form-builder.js'), [
    'depends' => JqueryAsset::className(),
]);
$this->registerJs($ready);

