<?php
/**
 * Created by PhpStorm.
 * User: Jawdat Sobh
 * Date: 11/15/2018
 * Time: 2:31 PM
 *
 * @var $this View
 * @var $dataLocator DataLocator
 * @var $context FileController
 */

use backend\controllers\FormController;
use cnd\grid\Attribute;
use cnd\grid\DataLocator;
use cnd\grid\DataView;
use common\models\Form;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$this->title = "Manage Forms";

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
                 * @var $data Form
                 * @var $view DataView
                 */
                return str_pad($data->id, 8, '0', STR_PAD_LEFT);
            },
            'filterBy' => Attribute::FILTER_NUMBER,
        ],
        'name' => [
            'label' => 'Name',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                /**
                 * @var $attribute Attribute
                 * @var $data Form
                 * @var $view DataView
                 */
                return $data->name;
            },
        ],
        'title' => [
            'label' => 'Title',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                /**
                 * @var $attribute Attribute
                 * @var $data Form
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
                 * @var $data Form
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
                 * @var $data Form
                 * @var $view DataView
                 */
                return $data->status_label;
            },
            'filterBy' => Attribute::FILTER_LIST,
            'filterList' => (new Form())->status_list,
        ],
    ],
    'headerLinks' => [
        Yii::$app->permission->can('/form/manage-meta-data') ? Html::a('Add New', Url::to(['manage-meta-data']), ['class' => 'btn btn-success']) : null,
    ],
    'rowLinks' => [
        function ($row){
            if (isset($row->structure['fields']) && is_array($row->structure['fields']) && !empty($row->structure['fields']) && Yii::$app->permission->can('/form/publish-request')) {
                return Html::a('Publish Request', Url::to(['publish-request', 'id' => $row->id]), ['class' => 'btn bg-maroon']);
            }
            return null;
        },
        function ($row){
            if (Yii::$app->permission->can('/form/manage-structure')) {
                return Html::a('Form Structure', Url::to(['manage-structure', 'id' => $row->id]), ['class' => 'btn bg-orange']);
            }
            return null;
        },
        function ($row) {
            if (Yii::$app->permission->can('/cms/content/manage')) {
                $c = Yii::$app->cms->getId('cms.category.defaultFormCategory');
                return Html::a('Content', Url::to(['/cms/content/manage','id' => $row->content_id,'c'=>$c,'s'=>'form-'.$row->id]), ['class' => 'btn bg-purple','target'=>'_blank']);
            }
            return null;
        },
        function ($row){
            if (Yii::$app->permission->can('/form/manage-meta-data')) {
                return Html::a('Edit', Url::to(['manage-meta-data', 'id' => $row->id]), ['class' => 'btn btn-info']);
            }
            return null;
        },
        function ($row){
            if (Yii::$app->permission->can('/form/delete')) {
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