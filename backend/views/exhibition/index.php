<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 1/29/2019
 * Time: 8:43 AM
 *
 */

use cnd\grid\Attribute;
use cnd\grid\DataView;
use cnd\grid\DataViewLocator;
use common\models\Exhibition;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use cnd\grid\DataLocator;
use backend\controllers\ExhibitionController;

$view = $this;
$context = $this->context;

assert($view instanceof View);
assert($dataLocator instanceof DataLocator);
assert($context instanceof ExhibitionController);

$this->title = "Exhibitions Management";

$dv = new DataView([
    'dataLocator' => $dataLocator,
    'searchColumns' => DataView::SEARCH_COLUMNS_TWO,
    'attributes' => [
        'id' => [
            'label' => 'ID',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof Exhibition);
                assert($view instanceof DataViewLocator);
                return str_pad($data->id, 8, '0', STR_PAD_LEFT);
            },
            'filterBy' => Attribute::FILTER_NUMBER,
        ],
        'name' => [
            'label' => 'Name',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof Exhibition);
                assert($view instanceof DataViewLocator);
                return $data->name;
            },
        ],
        'country' => [
            'label' => 'Country',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof Exhibition);
                assert($view instanceof DataViewLocator);
                return $data->country;
            },
            'filterBy' => Attribute::FILTER_LIST,
            'filterList' => Yii::$app->countries(),
        ],
        'region' => [
            'label' => 'Region',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof Exhibition);
                assert($view instanceof DataViewLocator);
                return $data->region;
            },
        ],
        'year' => [
            'label' => 'Year',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof Exhibition);
                assert($view instanceof DataViewLocator);
                return $data->year;
            },
        ],
    ],
    'headerLinks' => [
        Yii::$app->permission->can('/exhibition/manage') ? Html::a('Add New', Url::to(['manage']), ['class' => 'btn btn-success']) : null,
    ],
    'rowLinks' => [
        function ($row) {
            if (Yii::$app->permission->can('/exhibition/manage')) {
                return Html::a('Edit', Url::to(['manage', 'id' => $row->id]), ['class' => 'btn btn-info']);
            }
            return null;
        },
        function ($row) {
            if (Yii::$app->permission->can('/exhibition/delete')) {
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
        'country' => [
            'sortable' => true,
        ],
        'region' => [
            'sortable' => true,
        ],
        'year' => [
            'sortable' => true,
        ],
    ]
]);
echo $dv->render();
