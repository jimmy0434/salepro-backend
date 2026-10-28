<?php


use backend\controllers\NewsController;
use cnd\grid\Attribute;
use cnd\grid\DataView;
use cnd\grid\DataViewLocator;
use common\models\News;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use cnd\grid\DataLocator;

$view = $this;
$context = $this->context;

assert($view instanceof View);
assert($dataLocator instanceof DataLocator);
assert($context instanceof NewsController);

$this->title = "News Management";

$dv = new DataView([
    'dataLocator' => $dataLocator,
    'searchColumns' => DataView::SEARCH_COLUMNS_TWO,
    'attributes' => [
        'id' => [
            'label' => 'ID',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof News);
                assert($view instanceof DataViewLocator);
                return str_pad($data->id, 8, '0', STR_PAD_LEFT);
            },
            'filterBy' => Attribute::FILTER_NUMBER,
        ],
        'image' => [
            'label' => 'Image',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof News);
                assert($view instanceof DataViewLocator);
                if ($dataLocator->export) {
                    if ($data->imageFactory !== null) {
                        $url = $data->imageFactory->url;
                        if ($url) {
                            return \yii\bootstrap\Html::a('Show Image', $url, ['target' => '_blank']);
                        }
                    }
                    return '';
                } else {
                    if (get_class($view) == \cnd\grid\Card::className()) {
                        if ($data->imageFactory !== null) {
                            return '<div style="position:relative;">' . $data->imageFactory->displayImage(['100%', 'auto'], 'User Image', '', 'user-image') . '</div>';
                        }
                    } else {
                        if ($data->imageFactory !== null) {
                            return '<div style="position:relative;">' . $data->imageFactory->displayImage('icon', 'User Image', '', 'user-image') . '</div>';
                        }
                    }
                    return '';
                }
            },
            'filterBy' => Attribute::FILTER_NONE,
        ],
        'title' => [
            'label' => 'title',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof News);
                assert($view instanceof DataViewLocator);
                return $data->title;
            },
        ],
        'details' => [
            'label' => 'details',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof News);
                assert($view instanceof DataViewLocator);
                return $data->details;
            },
        ],
        'sector' => [
            'label' => 'Sector',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof News);
                assert($view instanceof DataViewLocator);
                return implode(',',$data->sectorsNames);
            },
            'filterBy' => Attribute::FILTER_NONE,
        ],
        'news_type' => [
            'label' => 'type',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof News);
                assert($view instanceof DataViewLocator);
                return $data->news_type;
            },
        ],
        
        'news_steep' => [
            'label' => 'Market Trends',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof News);
                assert($view instanceof DataViewLocator);
                return $data->news_steep;
            },
        ],
        'date' => [
            'label' => 'date',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof News);
                assert($view instanceof DataViewLocator);
                return $data->date;
            },
        ],
        'source_person' => [
            'label' => 'Source Name',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof News);
                assert($view instanceof DataViewLocator);
                return $data->source_person;
            },
        ],
        'Tags' => [
            'label' => 'Tags',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof News);
                assert($view instanceof DataViewLocator);
                return implode(',',$data->tagsNames);
            },
            'filterBy' => Attribute::FILTER_NONE,
        ],
        'created_at' => [
            'label' => 'Created at',
            'value' => function ($attribute, $data, $view) {
                assert($attribute instanceof Attribute);
                assert($data instanceof News);
                assert($view instanceof DataViewLocator);
                return date('l, d F, Y H:i',$data->created_at);
            },
            'filterBy' => Attribute::FILTER_NONE,
        ],
        'updated_at' => [
            'label' => 'Last Modification',
            'value' => function ($attribute, $data, $view) {
                assert($attribute instanceof Attribute);
                assert($data instanceof News);
                assert($view instanceof DataViewLocator);
                return date('l, d F, Y H:i',$data->updated_at);
            },
            'filterBy' => Attribute::FILTER_NONE,
        ],
    ],
    'headerLinks' => [
        Yii::$app->permission->can('/news/manage') ? Html::a('Add New', Url::to(['manage']), ['class' => 'btn btn-success']) : null,
    ],
    'rowLinks' => [
        function ($row) {
            if (Yii::$app->permission->can('/news/manage')) {
                return Html::a('Edit', Url::to(['manage', 'id' => $row->id]), ['class' => 'btn btn-info']);
            }
            return null;
        },
        function ($row) {
            if (Yii::$app->permission->can('/news/delete')) {
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
        'image' => [
            'sortable' => true,
            'contentOptions' => [
                'style' => 'text-align:center;white-space: nowrap;width:1%;'
            ],
        ],
        'title' => [
            'sortable' => true,
        ],
        'sector' => [
            'sortable' => true,
        ],
        'news_type' => [
            'sortable' => true,
        ],
        'date' => [
            'sortable' => true,
        ],
        'created_at' => [
            'sortable' => true,
            'contentOptions' => [
                'style' => 'text-align:center;white-space: nowrap;width:1%;'
            ],
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
