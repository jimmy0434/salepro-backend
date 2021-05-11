<?php


use common\models\SteepAnalysis;
use backend\controllers\SteepAnalysisController;
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
assert($context instanceof SteepAnalysisController);

$this->title = 'Steep Analysis';

$statuses = (new SteepAnalysis())->status_list;
$salesmanList = (new Salesman())->getActiveSalesmanList();



$dv = new DataView([
    'dataLocator' => $dataLocator,
    'searchColumns' => DataView::SEARCH_COLUMNS_TWO,
    'attributes' => [
        'id' => [
            'label' => 'ID',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof SteepAnalysis);
                assert($view instanceof DataViewLocator);
                return str_pad($data->id, 8, '0', STR_PAD_LEFT);
            },
            'filterBy' => Attribute::FILTER_NUMBER,
        ],
        'name' => [
            'label' => 'Name',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof SteepAnalysis);
                assert($view instanceof DataViewLocator);
                return $data->name;
            },
        ],

        'salesman_id'=>[
            'label'=>'Salesman',
            'value'=>function($attribute, $data, $view) use ($salesmanList) {
                assert($attribute instanceof Attribute);
                assert($data instanceof SteepAnalysis);
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
            //'filterBy' => Attribute::FILTER_LIST,
            //'filterList' => $salesmanList,
        ],
        'status'=>[
            'label'=>'Status',
            'value'=>function($attribute, $data, $view) use ($statuses){
                assert($attribute instanceof Attribute);
                assert($data instanceof SteepAnalysis);
                assert($view instanceof DataViewLocator);
                if(Yii::$app->permission->can('/steep-analysis/status')){
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
                assert($data instanceof SteepAnalysis);
                assert($view instanceof DataViewLocator);
                return date('l, d F, Y H:i',$data->updated_at);
            },
            'filterBy' => Attribute::FILTER_NONE,
        ],
    ],
    'headerLinks' => [],
    'rowLinks' => [
        function ($row) {
            if (Yii::$app->permission->can('/steep-analysis/view')) {
                return Html::a('View', Url::to(['view', 'id' => $row->id]), ['class' => 'btn btn-primary']);
            }
            return null;
        },
        function ($row) use ($context) {
            if (Yii::$app->permission->can('/steep-analysis/delete')) {
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

if(Yii::$app->permission->can('/Steep-Analysis/salesman')){
    $url = Url::toRoute('/Steep-Analysis/salesman');
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

if(Yii::$app->permission->can('/steep-analysis/status')){
    $url = Url::toRoute('/steep-analysis/status');
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


