<?php

/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 1/26/2019
 * Time: 10:18 AM
 *
 * @var $this View
 * @var $context SearchTagInput
 * @var $model ActiveRecord
 * @var $form ActiveForm
 */

use backend\widgets\SearchTagInput;
use cnd\core\components\ActiveRecord;
use cnd\form\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\View;

$context = $this->context;
$model = $context->model;
$form = $context->form;

$tagSearchUrl = Url::to(['/search/find-tags']);
$tagAddUrl = Url::to(['/search/add-tag']);
$tags = ArrayHelper::map($model->search->tags, 'id', function ($data) use($model) {
    $model->tags[] = $data->id;
    return [
        'id' => $data->id,
        'text' => $data->name,
    ];
});
$tags = array_values($tags);
$tagsList = Json::encode($tags);
$tagsOptions = <<< JS
    {
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
JS;
$tagsOptions = str_replace('__OPTIONS__', $tagsList, $tagsOptions);

echo $form->field($model, 'tags')->dropDownListAdvanced([], ['multiple' => true], $tagsOptions);
