<?php

use common\models\AppUsage;
use common\models\User;
use backend\controllers\AppUsageController;
use cnd\grid\Attribute;
use cnd\grid\DataView;
use cnd\grid\DataViewLocator;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\web\View;
use cnd\grid\DataLocator;

$view = $this;
$context = $this->context;

assert($view instanceof View);
assert($dataLocator instanceof DataLocator);
assert($context instanceof AppUsageController);

$this->title = "App usage statistics";

/*
$logModel = Log::className();
if (array_key_exists('logModel', Yii::$app->params) && Yii::$app->params['logModel']) {
    $logModel = Yii::$app->params['logModel'];
}
*/

$dv = new DataView([
    'dataLocator' => $dataLocator,
    'searchColumns' => DataView::SEARCH_COLUMNS_TWO,
    'attributes' => [
        'id' => [
            'label' => 'ID',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof AppUsage);
                assert($view instanceof DataViewLocator);
                return str_pad($data->id, 8, '0', STR_PAD_LEFT);
            },
            'filterBy' => Attribute::FILTER_NUMBER,
        ],
        'date' => [
            'label' => 'Backend date/time',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof AppUsage);
                assert($view instanceof DataViewLocator);
                return $data->date;
            },
        ],
        'user_id'=>[
            'label'=>'User',
            'value'=>function($attribute,$data){
                if($data->user !== null){
                    return $data->user->profile !== null?$data->user->profile->userName:$data->user->username;
                }
                return 'GUEST';
            },
            'filterBy' => Attribute::FILTER_LIST,
            'filterList' => ArrayHelper::map(User::find()->where(['!=','type',User::TYPE_ROOT])->all(),'id',function($data){
                return $data->profile !== null?$data->profile->userName:$data->username;
            },function($data){
                return $data->type_label;
            }),
        ],
        'action' => [
            'filter' => false,
            'label' => 'Action',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof AppUsage);
                assert($view instanceof DataViewLocator);
                if($data->message[0]=='$') {
                    $pieces = explode("|", $data->message);
                    return ltrim($pieces[1], 'Action:');
                } else return $data->message;
            },
        ],
        'object' => [
            'filter' => false,
            'label' => 'Object',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof AppUsage);
                assert($view instanceof DataViewLocator);
                if($data->message[0]=='$') {
                    $pieces = explode("|", $data->message);
                    return ltrim($pieces[2], 'Object:');
                } else return 'n/a';
            },
        ],
        'status' => [
            'filter' => false,
            'label' => 'Status',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof AppUsage);
                assert($view instanceof DataViewLocator);
                if($data->message[0]=='$') {
                    $pieces = explode("|", $data->message);
                    return ltrim($pieces[3], 'Status:');
                } else return 'n/a';
            },
        ],
        'device' => [
            'filter' => false,
            'label' => 'Device',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof AppUsage);
                assert($view instanceof DataViewLocator);
                if($data->message[0]=='$') {
                    $pieces = explode("|", $data->message);
                    return ltrim($pieces[4], 'Device:');
                } else return 'n/a';
            },
        ],
        'app_ts' => [
            'filter' => false,
            'label' => 'App date/time',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof AppUsage);
                assert($view instanceof DataViewLocator);
                if($data->message[0]=='$')
                {
                    $pieces = explode("|", $data->message);
                    return ltrim($pieces[0], '$');
                } else return 'n/a';
            },
        ],
    ],
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
        'date' => [
            'sortable' => true,
        ],
        'user_id'=>[
            'sortable' => true,
        ],
        'action' => [
            'sortable' => false,
        ],
        'object' => [
            'sortable' => false,
        ],
        'device' => [
            'sortable' => false,
        ],
        'status' => [
            'sortable' => false,
        ],
        'app_ts' => [
            'sortable' => false,
        ],
    ]
]);
echo $dv->render();
