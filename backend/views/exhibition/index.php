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
        'sector' => [
            'label' => 'Sector',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof Exhibition);
                assert($view instanceof DataViewLocator);
                return implode(',',$data->sectorsNames);
            },
            'filterBy' => Attribute::FILTER_NONE,
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
                return implode(',',$data->countriesNames);
            },
            'filterBy' => Attribute::FILTER_NONE,
        ],
        'region' => [
            'label' => 'Region',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof Exhibition);
                assert($view instanceof DataViewLocator);
                return implode(',',$data->regionsNames);
            },
            'filterBy' => Attribute::FILTER_NONE,
        ],
        'city' => [
            'label' => 'City',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof Exhibition);
                assert($view instanceof DataViewLocator);
                return $data->city;
            },
        ],
        
        'venue' => [
            'label' => 'Venue',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof Exhibition);
                assert($view instanceof DataViewLocator);
                return $data->venue;
            },
        ],
        'edition' => [
            'label' => 'Edition',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof Exhibition);
                assert($view instanceof DataViewLocator);
                return $data->edition;
            },
        ],
        'frequency' => [
            'label' => 'Frequency',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof Exhibition);
                assert($view instanceof DataViewLocator);
                return $data->frequency;
            },
        ],
        'organizer' => [
            'label' => 'organizer',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof Exhibition);
                assert($view instanceof DataViewLocator);
                return $data->organizer;
            },
        ],

        'lasteditionmonth' => [
            'label' => 'lasteditionmonth',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof Exhibition);
                assert($view instanceof DataViewLocator);
                return $data->lasteditionmonth;
            },
        ],

        'lasteditionyear' => [
            'label' => 'lasteditionyear',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof Exhibition);
                assert($view instanceof DataViewLocator);
                return $data->lasteditionyear;
            },
        ],

        'upcomingeditionmonth' => [
            'label' => 'upcomingeditionmonth',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof Exhibition);
                assert($view instanceof DataViewLocator);
                return $data->upcomingeditionmonth;
            },
        ],

        'upcomingeditionyear' => [
            'label' => 'upcomingeditionyear',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof Exhibition);
                assert($view instanceof DataViewLocator);
                return $data->upcomingeditionyear;
            },
        ],

        'nbofvisitors' => [
            'label' => 'nbofvisitors',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof Exhibition);
                assert($view instanceof DataViewLocator);
                return $data->nbofvisitors;
            },
        ],

        'nbofexhebitors' => [
            'label' => 'nbofexhebitors',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof Exhibition);
                assert($view instanceof DataViewLocator);
                return $data->nbofexhebitors;
            },
        ],

        'nbofseminars' => [
            'label' => 'nbofseminars',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof Exhibition);
                assert($view instanceof DataViewLocator);
                return $data->nbofseminars;
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
        'updated_at' => [
            'label' => 'Last Modification',
            'value' => function ($attribute, $data, $view) {
                assert($attribute instanceof Attribute);
                assert($data instanceof Exhibition);
                assert($view instanceof DataViewLocator);
                return date('l, d F, Y H:i',$data->updated_at);
            },
            'filterBy' => Attribute::FILTER_NONE,
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
        'sector' => [
            'sortable' => true,
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
        'city' => [
            'sortable' => true,
        ],
       
        'venue' => [
            'sortable' => true,
        ],
        'edition' => [
            'sortable' => true,
        ],
        'frequency' => [
            'sortable' => true,
        ],
        'organizer' => [
            'sortable' => true,
        ],
        'year' => [
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
