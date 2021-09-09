<?php
/**
 *
 * @var $this View
 * @var $context AutoCompleteInput
 * @var $model ActiveRecord
 * @var $form ActiveForm
 * @var $property string
 * @var $title string
 * @var $field ActiveField
 */

use backend\widgets\AutoCompleteInput;
use cnd\attributes\ActiveField;
use yii\web\View;
use cnd\core\components\ActiveRecord;
use cnd\form\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;

$context = $this->context;
$model = $context->model;
$form = $context->form;
$property = $context->property;
$title = $context->title;

$tagSearchUrl = Url::to($context->findUrl);
$tagAddUrl = Url::to($context->addUrl);
$tags = ArrayHelper::map($context->data, 'id', function ($data) use ($model, $property) {
    /**
     * @var $data ActiveRecord
     */
    $model->$property[] = $data->id;
    $name = null;
    if($data->hasProperty('portfolio')){
        $name = $data->portfolio->name;
    }else if($data->hasProperty('name')){
        $name = $data->name;
    }
    return [
        'id' => $data->id,
        'text' => $name,
    ];
});
$tags = array_values($tags);
$tagsList = Json::encode($tags);
$tagsOptions = <<< JS
    (function(){
        return {
            valueField: 'id',
            labelField: 'text',
            searchField: 'text',
            create: function (input, callback){
                $.ajax({
                    url: '{$tagAddUrl}',
                    type: 'POST',
                    data : {name:input},
                    success: function (result) {
                        if (result) {
                            callback({ id: result.id, text: input });
                        }
                    }
                });
            },
            options: __OPTIONS__,
            plugins: ['remove_button'],
            render: {
                option: function(item, escape) {
                    return '<div>' +
                        '<span class="title">' +
                            '<span class="name">' + escape(item.text) + '</span>' +
                        '</span>' +
                    '</div>';
                },
                item: function(item, escape) {
                    return '<div>' +
                        '<span class="title">' +
                            '<span class="name">' + escape(item.text) + '</span>' +
                        '</span>' +
                    '</div>';
                }
            },
            load: function(query, callback) {
                if (!query.length) return callback();
                $.ajax({
                    url: '{$tagSearchUrl}',
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
    })()             
JS;
$tagsOptions = str_replace('__OPTIONS__', $tagsList, $tagsOptions);

$field = $form->field($model, $property)->dropDownListAdvanced([], ['multiple' => true], $tagsOptions);
if ($title) {
    $field = $field->label($title);
}
echo $field;
