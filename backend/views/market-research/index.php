<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 1/29/2019
 * Time: 11:22 AM
 */

use backend\controllers\MarketResearchController;
use cnd\grid\Attribute;
use cnd\grid\DataView;
use cnd\grid\DataViewLocator;
use common\models\MarketResearch;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use cnd\grid\DataLocator;

$view = $this;
$context = $this->context;

assert($view instanceof View);
assert($dataLocator instanceof DataLocator);
assert($context instanceof MarketResearchController);

$this->title = "Market Research Management";

$dv = new DataView([
    'dataLocator' => $dataLocator,
    'searchColumns' => DataView::SEARCH_COLUMNS_TWO,
    'attributes' => [
        'id' => [
            'label' => 'ID',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof MarketResearch);
                assert($view instanceof DataViewLocator);
                return str_pad($data->id, 8, '0', STR_PAD_LEFT);
            },
            'filterBy' => Attribute::FILTER_NUMBER,
        ],
        'name' => [
            'label' => 'Name',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof MarketResearch);
                assert($view instanceof DataViewLocator);
                return $data->name;
            },
        ],
        'countries' => [
            'label' => 'Countries',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof MarketResearch);
                assert($view instanceof DataViewLocator);
                return implode('<span class="text-muted">,</span> ', ArrayHelper::map($data->countries, 'id', 'country'));
            },
            'filterBy' => Attribute::FILTER_NONE,
        ],
        'regions' => [
            'label' => 'Regions',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof MarketResearch);
                assert($view instanceof DataViewLocator);
                return implode('<span class="text-muted">,</span> ', ArrayHelper::map($data->regions, 'id', 'region'));
            },
            'filterBy' => Attribute::FILTER_NONE,
        ],
        'year' => [
            'label' => 'Year',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof MarketResearch);
                assert($view instanceof DataViewLocator);
                return $data->year;
            },
        ],
        'source' => [
            'label' => 'Source',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof MarketResearch);
                assert($view instanceof DataViewLocator);
                return $data->source;
            },
        ],
        'sector_id' => [
            'label' => 'Sector',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof MarketResearch);
                assert($view instanceof DataViewLocator);
                if ($data->sector && $data->sector->portfolio) {
                    return $data->sector->portfolio->name;
                }
                return null;
            },
        ],
        'products' => [
            'label' => 'Products',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof MarketResearch);
                assert($view instanceof DataViewLocator);
                return implode('<span class="text-muted">,</span> ', array_filter(ArrayHelper::map($data->products, 'id', function ($row) {
                    if ($row->portfolio) {
                        return $row->portfolio->name;
                    }
                    return null;
                })));
            },
            'filterBy' => Attribute::FILTER_NONE,
        ],
        'updated_at' => [
            'label' => 'Last Modification',
            'value' => function ($attribute, $data, $view) {
                assert($attribute instanceof Attribute);
                assert($data instanceof MarketResearch);
                assert($view instanceof DataViewLocator);
                return date('l, d F, Y H:i',$data->updated_at);
            },
            'filterBy' => Attribute::FILTER_NONE,
        ],
    ],
    'headerLinks' => [
        Yii::$app->permission->can('/market-research/manage') ? Html::a('Add New', Url::to(['manage']), ['class' => 'btn btn-success']) : null,
    ],
    'rowLinks' => [
        function ($row) {
            if (Yii::$app->permission->can('/market-research/manage')) {
                return Html::a('Edit', Url::to(['manage', 'id' => $row->id]), ['class' => 'btn btn-info']);
            }
            return null;
        },
        function ($row) {
            if (Yii::$app->permission->can('/market-research/delete')) {
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
        'sector_id' => [
            'sortable' => true,
        ],
        'products' => [
            'sortable' => false,
        ],
        'countries' => [
            'sortable' => false,
        ],
        'regions' => [
            'sortable' => false,
        ],
        'year' => [
            'sortable' => true,
        ],
        'source' => [
            'sortable' => true,
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
