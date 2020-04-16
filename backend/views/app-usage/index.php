<?php

use common\models\AppUsage;
use backend\controllers\AppUsageController;
use cnd\grid\Attribute;
use cnd\grid\DataView;
use cnd\grid\DataViewLocator;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use cnd\grid\DataLocator;

$view = $this;
$context = $this->context;

assert($view instanceof View);
assert($dataLocator instanceof DataLocator);
assert($context instanceof AppUsageController);

$this->title = "App usage statistics";

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
        'user' => [
            'label' => 'User',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof AppUsage);
                assert($view instanceof DataViewLocator);
                return $data->user->name;
            },
        ],
        'action' => [
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
        'user' => [
            'sortable' => false,
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
