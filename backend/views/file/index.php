<?php
/**
 * Created by PhpStorm.
 * User: JawdatSobh
 * Date: 08/11/2018
 * Time: 16:49
 *
 * @var $this View
 * @var $dataLocator DataLocator
 * @var $context FileController
 */

use backend\controllers\FileController;
use cnd\grid\Attribute;
use cnd\grid\DataLocator;
use cnd\grid\DataView;
use common\models\File;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$this->title = "Manage Files";

$context = $this->context;

$dv = new DataView([
    'dataLocator' => $dataLocator,
    'searchColumns' => DataView::SEARCH_COLUMNS_TWO,
    'attributes' => [
        'id' => [
            'label' => 'ID',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                /**
                 * @var $attribute Attribute
                 * @var $data File
                 * @var $view DataView
                 */
                return str_pad($data->id, 8, '0', STR_PAD_LEFT);
            },
            'filterBy' => Attribute::FILTER_NUMBER,
        ],
        'title' => [
            'label' => 'Title',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                /**
                 * @var $attribute Attribute
                 * @var $data File
                 * @var $view DataView
                 */
                return $data->title;
            },
        ],
        'version' => [
            'label' => 'Version',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                /**
                 * @var $attribute Attribute
                 * @var $data File
                 * @var $view DataView
                 */
                return $data->version;
            },
        ],
        'status' => [
            'label' => 'Status',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                /**
                 * @var $attribute Attribute
                 * @var $data File
                 * @var $view DataView
                 */
                return $data->status_label;
            },
            'filterBy' => Attribute::FILTER_LIST,
            'filterList' => (new File())->status_list,
        ],
    ],
    'headerLinks' => [
        Yii::$app->permission->can('/file/manage-meta-data') ? Html::a('Add New', Url::to(['manage-meta-data']), ['class' => 'btn btn-success']) : null,
    ],
    'rowLinks' => [
        function ($row){
            if (Yii::$app->permission->can('/file/manage-upload')) {
                return Html::a('Upload', Url::to(['manage-upload', 'id' => $row->id]), ['class' => 'btn bg-orange']);
            }
            return null;
        },
        function ($row){
            if ($row->version && Yii::$app->permission->can('/file/download')) {
                return Html::a('Download', Url::to(['download', 'id' => $row->id]), ['class' => 'btn bg-yellow','target'=>'_blank']);
            }
            return null;
        },
        function ($row){
            if (Yii::$app->permission->can('/file/manage-meta-data')) {
                return Html::a('Edit', Url::to(['manage-meta-data', 'id' => $row->id]), ['class' => 'btn btn-info']);
            }
            return null;
        },
        function ($row){
            if (Yii::$app->permission->can('/file/delete')) {
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
        'title' => [
            'sortable' => true,
        ],
        'version' => [
            'sortable' => true,
        ],
        'status' => [
            'sortable' => true,
        ],
    ]
]);
echo $dv->render();
