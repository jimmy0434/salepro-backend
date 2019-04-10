<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 2/6/2019
 * Time: 12:24 PM
 */

use backend\controllers\BusinessUnitController;
use backend\controllers\CompetitionController;
use cnd\grid\Attribute;
use cnd\grid\DataView;
use cnd\grid\DataViewLocator;
use common\models\BusinessUnit;
use common\models\Competitor;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use cnd\grid\DataLocator;

$view = $this;
$context = $this->context;

assert($view instanceof View);
assert($dataLocator instanceof DataLocator);
assert($context instanceof CompetitionController);

$this->title = 'Competitions';

$statuses = (new Competitor())->status_list;

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
        'status'=>[
            'label'=>'Status',
            'value'=>function($attribute,$data, $view) use($statuses){
                assert($attribute instanceof Attribute);
                assert($data instanceof Competitor);
                assert($view instanceof DataViewLocator);
                if(Yii::$app->permission->can('/competition/status')){
                    return Html::dropDownList('status',$data->status,$statuses,['class'=>'form-control status-ddl','id'=>'status-'.$data->id,'data-id'=>$data->id]);
                }
                return $data->status_label;
            },
            'filterBy' => Attribute::FILTER_LIST,
            'filterList' => $statuses,
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
        'status' => [
            'sortable' => true,
            'contentOptions' => [
                'style' => 'width:150px;'
            ],
        ],
    ]
]);
echo $dv->render();

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
