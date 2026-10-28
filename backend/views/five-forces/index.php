<?php


use common\models\FiveForces;
use backend\controllers\FiveForcesController;
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
assert($context instanceof FiveForcesController);

$this->title = 'Five Forces';


$salesmanList = (new Salesman())->getActiveSalesmanList();


$dv = new DataView([
    'dataLocator' => $dataLocator,
    'searchColumns' => DataView::SEARCH_COLUMNS_TWO,
    'attributes' => [
        'id' => [
            'label' => 'ID',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof FiveForces);
                assert($view instanceof DataViewLocator);
                return str_pad($data->id, 8, '0', STR_PAD_LEFT);
            },
            'filterBy' => Attribute::FILTER_NUMBER,
        ],
        'name' => [
            'label' => 'Product',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof FiveForces);
                assert($view instanceof DataViewLocator);
                return $data->name;
            },
        ],

        'salesman_id'=>[
            'label'=>'Salesman',
            'value'=>function($attribute, $data, $view) use ($salesmanList) {
                assert($attribute instanceof Attribute);
                assert($data instanceof FiveForces);
                assert($view instanceof DataViewLocator);
                if(Yii::$app->permission->can('/five-forces/salesman')) {
                    return Html::dropDownList('salesman', $data->salesman_id, $salesmanList,
                        ['class' => 'form-control salesman-ddl',
                          'id' => 'status-'.$data->id,
                          'data-id' => $data->id
                        ]);
                }
                return $data->salesman_id;
            },
           
        ],
     
        'updated_at' => [
            'label' => 'Last Modification',
            'value' => function ($attribute, $data, $view) {
                assert($attribute instanceof Attribute);
                assert($data instanceof FiveForces);
                assert($view instanceof DataViewLocator);
                return date('l, d F, Y H:i',$data->updated_at);
            },
            'filterBy' => Attribute::FILTER_NONE,
        ],
    ],
    'headerLinks' => [],
    'rowLinks' => [
        function ($row) {
            if (Yii::$app->permission->can('/five-forces/view')) {
                return Html::a('View', Url::to(['view', 'id' => $row->id]), ['class' => 'btn btn-primary']);
            }
            return null;
        },
        function ($row) use ($context) {
            if (Yii::$app->permission->can('/five-forces/delete')) {
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
      
        
        'updated_at' => [
            'sortable' => true,
            'contentOptions' => [
                'style' => 'text-align:center;white-space: nowrap;width:1%;'
            ],
        ],
    ]
]);
echo $dv->render();

if(Yii::$app->permission->can('/five-forces/salesman')){
    $url = Url::toRoute('/five-forces/salesman');
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




