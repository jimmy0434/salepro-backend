<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 2/6/2019
 * Time: 8:54 AM
 */

use backend\controllers\ProductDetailsController;
use cnd\grid\Attribute;
use cnd\grid\DataView;
use cnd\grid\DataViewLocator;
use common\models\Product;
use common\models\ProductDetail;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use cnd\grid\DataLocator;

$view = $this;
$context = $this->context;
$product = $context->product;

assert($view instanceof View);
assert($dataLocator instanceof DataLocator);
assert($context instanceof ProductDetailsController);
assert($product instanceof Product);

$this->title = "Product Details Management | " . $product->portfolio->name;

$dv = new DataView([
    'dataLocator' => $dataLocator,
    'searchColumns' => DataView::SEARCH_COLUMNS_TWO,
    'attributes' => [
        'id' => [
            'label' => 'ID',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof ProductDetail);
                assert($view instanceof DataViewLocator);
                return str_pad($data->id, 8, '0', STR_PAD_LEFT);
            },
            'filterBy' => Attribute::FILTER_NUMBER,
        ],
        'section' => [
            'label' => 'Section',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof ProductDetail);
                assert($view instanceof DataViewLocator);
                return $data->section_label;
            },
        ],
        'title' => [
            'label' => 'Title',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof ProductDetail);
                assert($view instanceof DataViewLocator);
                return $data->title;
            },
        ],
    ],
    'headerLinks' => [
        Yii::$app->permission->can('/portfolio/index') ? Html::a('Back To Products', Url::to(['/portfolio/index', 't' => $context->target]), ['class' => 'btn btn-default']) : null,
        '&nbsp;&nbsp;',
        Yii::$app->permission->can('/product-details/manage') ? Html::a('Add New', Url::to(['manage', 'p' => $product->id, 't' => $context->target]), ['class' => 'btn btn-success']) : null,
    ],
    'rowLinks' => [
        function ($row) use ($context, $product) {
            if (Yii::$app->permission->can('/product-details-item/index')) {
                return Html::a('Contents', Url::to(['/product-details-item/index', 'id' => $row->id, 'p' => $product->id, 't' => $context->target, 'd' => $row->id]), ['class' => 'btn btn-warning']);
            }
            return null;
        },
        function ($row) use ($context, $product) {
            if (Yii::$app->permission->can('/product-details/manage')) {
                return Html::a('Edit', Url::to(['manage', 'id' => $row->id, 'p' => $product->id, 't' => $context->target]), ['class' => 'btn btn-info']);
            }
            return null;
        },
        function ($row) use ($context, $product) {
            if (Yii::$app->permission->can('/product-details/delete')) {
                return Html::a('Delete', Url::to(['delete', 'id' => $row->id, 'p' => $product->id, 't' => $context->target]), ['class' => 'btn btn-danger', 'data-confirm' => 'Are You Sure?']);
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
        'section' => [
            'sortable' => true,
            'contentOptions' => [
                'style' => 'text-align:center;white-space: nowrap;width:1%;'
            ],
        ],
        'title' => [
            'sortable' => true,
        ],
    ]
]);
echo $dv->render();
