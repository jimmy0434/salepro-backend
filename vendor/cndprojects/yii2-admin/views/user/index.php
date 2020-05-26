<?php
$this->title = 'Manage '.$this->context->typeTitle;

use yii\helpers\Html;
use yii\helpers\Url;
use cnd\grid\Attribute;
use cnd\grid\DataView;
use yii\bootstrap\Modal;

$route = '/'.$this->context->uniqueId;
$headers = $this->context->manageHeaderButtons();

$autoLoginDefinition = Yii::$app->getModule('admin')->autoLoginDefinition;
$autoLoginDefinition = $autoLoginDefinition($this->context->type);

$script = <<< JS
$(document).ready(function(){
              setTimeout(function() {
                    $('#statusMsg').fadeOut('fast');
               }, 5000); // <-- time in milliseconds
      });
JS;
$this->registerJs($script);

if(Yii::$app->session->hasFlash('refresh'))
{
    echo '<div id="statusMsg"><b>';
    echo Yii::$app->session->getFlash('refresh');
    echo '</b></div>';
}

if(Yii::$app->permission->can($route.'/manage')){
    $headers[] = Html::a('Add New', Url::to(['manage']),['class'=>'btn btn-success']).' '.
                 Html::a('Send Refresh to all', Url::to(['salesman/notify','id'=>0]),['class'=>'btn btn-primary']);
}
echo $this->context->beforeGrid();

$dv = new DataView([
    'dataLocator'=>$dataLocator,
    'searchColumns' => DataView::SEARCH_COLUMNS_TWO,
    'attributes'=>array_merge([
        'self.id'=>[
            'label'=>'ID',
            'value'=>function($attribute,$data){
                return str_pad($data->id,8,'0',STR_PAD_LEFT);
            },
            'filterBy' => Attribute::FILTER_NUMBER,
        ],
        'self.username'=>[
            'label'=>'Username',
            'value'=>function($attribute,$data){
                return $data->username;
            },
        ],
        'self.email'=>[
            'label'=>'Email',
            'value'=>function($attribute,$data){
                return $data->email;
            },
        ],
        'self.status'=>[
            'label'=>'Status',
            'value'=>function($attribute,$data){
                return $data->status_label;
            },
            'filterBy' => Attribute::FILTER_LIST,
            'filterList' => Yii::$app->user->identity->status_list,
        ],
        'self.register'=>[
            'label'=>'Registered By',
            'value'=>function($attribute,$data){
                return $data->register_label;
            },
            'filterBy' => Attribute::FILTER_LIST,
            'filterList' => Yii::$app->user->identity->register_list,
        ],
        'self.created_at'=>[
            'label'=>'Registered At',
            'value'=>function($attribute,$data){
                return date('l, d F, Y @H:i',$data->created_at);
            },
            'filterBy' => Attribute::FILTER_NONE,
        ],
    ],$this->context->getViewAttributes($dataLocator)),
    'headerLinks'=>$headers,
    'rowLinks'=>array_merge($this->context->manageRowButtons(),[
        function($row) use($route){
            if(Yii::$app->permission->can($route.'/access-list')){
                return Html::a('Devices', Url::to(['access-list','id'=>$row->id]),['class'=>'btn btn-warning btn-devices']);
            }
            return null;
        },
        function($row) use($route){
            if(Yii::$app->permission->can($route.'/access-list')){
                return Html::a('Api Access', Url::to(['api-access-log','id'=>$row->id]),['class'=>'btn bg-olive btn-api-log']);
            }
            return null;
        },
        function($row) use($route){
            if(Yii::$app->permission->can($route.'/view')){
                return Html::a('View', Url::to(['view','id'=>$row->id]),['class'=>'btn btn-primary']);
            }
            return null;
        },
        function($row) use($route){
            if(Yii::$app->permission->can($route.'/manage')){
                return Html::a('Edit', Url::to(['manage','id'=>$row->id]),['class'=>'btn btn-info']);
            }
            return null;
        },
        function($row) use($route){
            if($row->type != common\models\User::TYPE_ROOT){
                if(Yii::$app->permission->can($route.'/delete')){
                    return Html::a('Delete', Url::to(['delete','id'=>$row->id]),['class'=>'btn btn-danger','data-confirm'=>'Are You Sure?']);
                }
            }
            return null;
        },
    ])
]);
$dv->addView('grid',[
    'class'=>'\cnd\grid\GridTable',
    'columns'=>array_merge([
        'self.id'=>[
            'sortable'=>true,
        ],
    ],$this->context->gridTable(),$autoLoginDefinition?[]:[
        'self.username'=>[
            'sortable'=>true,
        ],
        'self.email'=>[
            'sortable'=>true,
        ],
    ],[
        'self.status'=>[
            'sortable'=>true,
        ],
        'self.register'=>[
            'sortable'=>true,
        ],
        'self.created_at'=>[
            'sortable'=>true,
        ]
    ]),
]);

$card = $this->context->card();
if($card && is_callable($card)){
    $dv->addView('card',[
        'class'=>'\cnd\grid\Card',
        'columnSize'=>$this->context->columnsCount,
        'blocksit'=>$this->context->blocksit,
        'containerStyle' => $this->context->containerCardStyle,
        'template'=> function($attributes) use($card){
            return $card($attributes);
        },
    ]);
}else
if($card && is_string($card)){
    $dv->addView('card',[
        'class'=>'\cnd\grid\Card',
        'columnSize'=>$this->context->columnsCount,
        'blocksit'=>$this->context->blocksit,
        'containerStyle' => $this->context->containerCardStyle,
        'template'=> $card,
    ]);
}
echo $dv->render();

echo $this->context->afterGrid();

Modal::begin([
    'header'=>'<h4>Devices</h4>',
    'id'=>'devices-modal',
    'size'=>'modal-lg',
 ]);

echo "<div id='modalDevicesContent'></div>";
Modal::end();

Modal::begin([
    'header'=>'<h4>Api Access Log</h4>',
    'id'=>'api-access-modal',
    'size'=>'modal-lg',
 ]);

echo "<div id='modalApiAccessContent'></div>";
Modal::end();

$script = <<< JS
$(document).on('click','.btn-devices',function(e){
    e.preventDefault();
    $('#devices-modal').find('#modalDevicesContent').html('Loading...').parents('#devices-modal').modal('show').find('#modalDevicesContent').load($(this).attr('href'));
});
$(document).on('click','.btn-api-log',function(e){
    e.preventDefault();
    $('#api-access-modal').find('#modalApiAccessContent').html('Loading...').parents('#api-access-modal').modal('show').find('#modalApiAccessContent').load($(this).attr('href'));
});
JS;
$this->registerJs($script);
