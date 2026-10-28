<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 2/6/2019
 * Time: 12:24 PM
 */

use common\models\Competitor;
use backend\controllers\CompetitionController;
use common\models\Salesman;
use backend\controllers\SalesmanController;
use cnd\grid\Attribute;
use cnd\grid\DataView;
use cnd\grid\DataViewLocator;
use cnd\grid\DataLocator;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$view = $this;
$context = $this->context;

assert($view instanceof View);
assert($dataLocator instanceof DataLocator);
assert($context instanceof CompetitionController);

$this->title = 'Competitions';
$merges = (new Competitor())->status_list;
$statuses = (new Competitor())->status_list;
$salesmanList = (new Salesman())->getActiveSalesmanList();

//Html::a('Очистить фильтры', ['index'], ['class' => 'btn btn-info'])

$dv = new DataView([
    'dataLocator' => $dataLocator,
    'searchColumns' => DataView::SEARCH_COLUMNS_TWO,
    'attributes' => [
        'id' => [
            'label' => 'ID',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof Competitor);
                assert($view instanceof DataViewLocator);
                return str_pad($data->id, 8, '0', STR_PAD_LEFT);
            },
            'filterBy' => Attribute::FILTER_NUMBER,
        ],
        'name' => [
            'label' => 'Name',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof Competitor);
                assert($view instanceof DataViewLocator);
                return $data->name;
            },
        ],

        'salesman_id'=>[
            'label'=>'Salesman',
            'value'=>function($attribute, $data, $view) use ($salesmanList) {
                assert($attribute instanceof Attribute);
                assert($data instanceof Competitor);
                assert($view instanceof DataViewLocator);
                if(Yii::$app->permission->can('/competition/salesman')) {
                    return Html::dropDownList('salesman', $data->salesman_id, $salesmanList,
                        ['class' => 'form-control salesman-ddl',
                          'id' => 'status-'.$data->id,
                          'data-id' => $data->id
                        ]);
                }
                return $data->salesman_id;
            },
            'filterBy' => Attribute::FILTER_LIST,
            'filterList' => $salesmanList,
        ],
        'merged'=>[
            'label'=>'Merged',
            'value'=>function($attribute, $data, $view) use ($merges){
                assert($attribute instanceof Attribute);
                assert($data instanceof Competitor);
                assert($view instanceof DataViewLocator);
                if(Yii::$app->permission->can('/competition/merged')){
                    return Html::dropDownList('merged', $data->merged, $merges,
                    ['class' => 'form-control merged-ddl',
                     'id' => 'merged-'.$data->id,
                     'data-id' => $data->id
                    ]);
                }
                return $data->merged_label;
            },
            'filterBy' => Attribute::FILTER_LIST,
            'filterList' => $merges,
        ],
        'status'=>[
            'label'=>'Status',
            'value'=>function($attribute, $data, $view) use ($statuses){
                assert($attribute instanceof Attribute);
                assert($data instanceof Competitor);
                assert($view instanceof DataViewLocator);
                if(Yii::$app->permission->can('/competition/status')){
                    return Html::dropDownList('status', $data->status, $statuses,
                        ['class' => 'form-control status-ddl',
                         'id' => 'status-'.$data->id,
                         'data-id' => $data->id
                        ]);
                }
                return $data->status_label;
            },
            'filterBy' => Attribute::FILTER_LIST,
            'filterList' => $statuses,
        ],
        'updated_at' => [
            'label' => 'Last Modification',
            'value' => function ($attribute, $data, $view) {
                assert($attribute instanceof Attribute);
                assert($data instanceof Competitor);
                assert($view instanceof DataViewLocator);
                return date('l, d F, Y H:i',$data->updated_at);
            },
            'filterBy' => Attribute::FILTER_NONE,
        ],
    ],
    'headerLinks' => [],
    'rowLinks' => [
        function ($row) {
            if (Yii::$app->permission->can('/competition/view')) {
                return Html::a('View', Url::to(['view', 'id' => $row->id]), ['class' => 'btn btn-primary']);
            }
            return null;
        },
        function ($row) use ($context) {
            if (Yii::$app->permission->can('/competition/delete')) {
                return Html::a('Delete', Url::to(['delete', 'id' => $row->id]), ['class' => 'btn btn-danger', 'data-confirm' => 'Are You Sure?']);
            }
            return null;
        },
    ]
]);
$dv->addView('grid', [
    'class' => '\cnd\grid\GridTable',
    'columns' => [
        'id' => [
            'sortable' => true,
            'contentOptions' => [
                'style' => 'text-align:center;white-space: nowrap;width:1%;'
            ],
        ],
        'name' => [
            'sortable' => true,
        ],
        'salesman_id' => [
            'sortable' => true,
            'contentOptions' => [
                'style' => 'width:300px;'
            ],
        ],
        'merged' => [
            'sortable' => true,
            'contentOptions' => [
                'style' => 'width:150px;'
            ],
        ],
        'status' => [
            'sortable' => true,
            'contentOptions' => [
                'style' => 'width:150px;'
            ],
        ],
        'updated_at' => [
            'sortable' => true,
            'contentOptions' => [
                'style' => 'text-align:center;white-space: nowrap;width:1%;'
            ],
        ],
    ]
]);
echo $dv->render();

if(Yii::$app->permission->can('/competition/salesman')){
    $url = Url::toRoute('/competition/salesman');
    $script = <<< JS
        $(document).on('change','.salesman-ddl',function(){
            var element = $(this);
            var data = {
                id : element.attr('data-id'),
                status : element.val()
            };
            $.ajax({
                type : 'post',
                url : '{$url}',
                data : data,
                dataType : 'json',
                beforeSend : function(){
                    element.prop('disabled',true);
                },
                success : function(response){
                    element.prop('disabled',false);
                },
                error : function(){
                    element.prop('disabled',false);
                }
            });
        });
JS;
    $this->registerJs($script);
}

if(Yii::$app->permission->can('/competition/status')){
    $url = Url::toRoute('/competition/status');
    $script = <<< JS
        $(document).on('change','.status-ddl',function(){
            var element = $(this);
            var data = {
                id : element.attr('data-id'),
                status : element.val()
            };
            $.ajax({
                type : 'post',
                url : '{$url}',
                data : data,
                dataType : 'json',
                beforeSend : function(){
                    element.prop('disabled',true);
                },
                success : function(response){
                    element.prop('disabled',false);
                },
                error : function(){
                    element.prop('disabled',false);
                }
            });
        });
JS;
    $this->registerJs($script);
}


if(Yii::$app->permission->can('/competition/merged')){
    $url = Url::toRoute('/competition/merged');
    $script = <<< JS
        $(document).on('change','.merged-ddl',function(){
            var element = $(this);
            var data = {
                id : element.attr('data-id'),
                merged : element.val()
            };
            $.ajax({
                type : 'post',
                url : '{$url}',
                data : data,
                dataType : 'json',
                beforeSend : function(){
                    element.prop('disabled',true);
                },
                success : function(response){
                    element.prop('disabled',false);
                },
                error : function(){
                    element.prop('disabled',false);
                }
            });
        });
JS;
    $this->registerJs($script);
}