<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 2/6/2019
 * Time: 9:30 AM
 */

use backend\controllers\ProductDetailsItemController;
use cnd\grid\Attribute;
use cnd\grid\DataView;
use cnd\grid\DataViewLocator;
use common\models\Product;
use common\models\ProductDetail;
use common\models\ProductDetailItem;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use cnd\grid\DataLocator;

$view = $this;
$context = $this->context;
$product = $context->product;
$detail = $context->detail;

assert($view instanceof View);
assert($dataLocator instanceof DataLocator);
assert($context instanceof ProductDetailsItemController);
assert($product instanceof Product);
assert($detail instanceof ProductDetail);

$this->title = "Product Details Contents Management";

$this->params['breadcrumbs'][] = ['label' =>  "Products", 'url' => ['/portfolio/index', 't' => $context->target]];
$this->params['breadcrumbs'][] = ['label' =>  $product->portfolio->name, 'url' => ['/product-details/index', 't' => $context->target, 'p' => $product->id]];
$this->params['breadcrumbs'][] = $detail->section_label.' / '.$detail->title;

$dv = new DataView([
    'dataLocator' => $dataLocator,
    'searchColumns' => DataView::SEARCH_COLUMNS_TWO,
    'attributes' => [
        'id' => [
            'label' => 'ID',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof ProductDetailItem);
                assert($view instanceof DataViewLocator);
                return str_pad($data->id, 8, '0', STR_PAD_LEFT);
            },
            'filterBy' => Attribute::FILTER_NUMBER,
        ],
        'type' => [
            'label' => 'Type',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof ProductDetailItem);
                assert($view instanceof DataViewLocator);
                return $data->type_label;
            },
        ],
        'title' => [
            'label' => 'Title',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof ProductDetailItem);
                assert($view instanceof DataViewLocator);
                return $data->title;
            },
        ],
    ],
    'headerLinks' => [
        Yii::$app->permission->can('/product-details-item/manage') ? Html::a('Add New File', Url::to(['manage', 'p' => $product->id, 't' => $context->target, 'd' => $detail->id, 'type' => ProductDetailItem::TYPE_FILE]), ['class' => 'btn btn-success']) : null,
        '&nbsp;&nbsp;',
        Yii::$app->permission->can('/product-details-item/manage') ? Html::a('Add New Content', Url::to(['manage', 'p' => $product->id, 't' => $context->target, 'd' => $detail->id, 'type' => ProductDetailItem::TYPE_CONTENT]), ['class' => 'btn btn-success']) : null,
    ],
    'rowLinks' => [
        function ($row) use ($context, $product, $detail) {
            if (Yii::$app->permission->can('/product-details-item/manage')) {
                return Html::a('Edit', Url::to(['manage', 'id' => $row->id, 'p' => $product->id, 't' => $context->target, 'd' => $detail->id]), ['class' => 'btn btn-info']);
            }
            return null;
        },
        function ($row) use ($context, $product, $detail) {
            if (Yii::$app->permission->can('/product-details-item/delete')) {
                return Html::a('Delete', Url::to(['delete', 'id' => $row->id, 'p' => $product->id, 't' => $context->target, 'd' => $detail->id]), ['class' => 'btn btn-danger', 'data-confirm' => 'Are You Sure?']);
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
        'type' => [
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
