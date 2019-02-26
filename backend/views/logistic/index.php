<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 2/25/2019
 * Time: 3:21 PM
 */

use cnd\grid\Attribute;
use cnd\grid\DataView;
use cnd\grid\DataViewLocator;
use common\models\Logistic;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use cnd\grid\DataLocator;
use backend\controllers\LogisticController;

$view = $this;
$context = $this->context;

assert($view instanceof View);
assert($dataLocator instanceof DataLocator);
assert($context instanceof LogisticController);

$this->title = "Logistics Management :: " . $context->categories[$context->category];

?>
    <div class="btn-group btn-group-justified" role="group" aria-label="targets">
        <?php
        foreach ($context->categories as $value => $label) {
            echo Html::a($label, ['index', 'c' => $value], ['class' => 'btn btn-default ' . ($value == $context->category ? 'active' : '')]);
        }
        ?>
    </div>
    <hr>
<?php

$dv = new DataView([
    'dataLocator' => $dataLocator,
    'searchColumns' => DataView::SEARCH_COLUMNS_TWO,
    'attributes' => [
        'id' => [
            'label' => 'ID',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof Logistic);
                assert($view instanceof DataViewLocator);
                return str_pad($data->id, 8, '0', STR_PAD_LEFT);
            },
            'filterBy' => Attribute::FILTER_NUMBER,
        ],
        'image' => [
            'label' => 'Image',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof Logistic);
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
                            return '<div style="position:relative;">' . $data->imageFactory->displayImage(['100%', 'auto'], 'Logistic Image', '', 'user-image') . '</div>';
                        }
                    } else {
                        if ($data->imageFactory !== null) {
                            return '<div style="position:relative;">' . $data->imageFactory->displayImage('icon', 'Logistic Image', '', 'user-image') . '</div>';
                        }
                    }
                    return '';
                }
            },
        ],
        'position' => [
            'label' => 'Position',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof Logistic);
                assert($view instanceof DataViewLocator);
                return $data->position;
            },
            'filterBy' => Attribute::FILTER_NUMBER,
        ],
        'name' => [
            'label' => 'Name',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof Logistic);
                assert($view instanceof DataViewLocator);
                return $data->name;
            },
        ],
        'category_id' => [
            'label' => 'Category',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof Logistic);
                assert($view instanceof DataViewLocator);
                return $data->category ? $data->category->name : '';
            },
            'filterBy' => Attribute::FILTER_LIST,
            'filterList' => $context->categories,
        ],
    ],
    'headerLinks' => [
        Yii::$app->permission->can('/logistic/manage') ? Html::a('Add New', Url::to(['manage', 'c' => $context->category]), ['class' => 'btn btn-success']) : null,
    ],
    'rowLinks' => [
        function ($row) use ($context) {
            if (Yii::$app->permission->can('/logistic/manage')) {
                return Html::a('Edit', Url::to(['manage', 'id' => $row->id, 'c' => $context->category]), ['class' => 'btn btn-info']);
            }
            return null;
        },
        function ($row) use ($context) {
            if (Yii::$app->permission->can('/logistic/delete')) {
                return Html::a('Delete', Url::to(['delete', 'id' => $row->id, 'c' => $context->category]), ['class' => 'btn btn-danger', 'data-confirm' => 'Are You Sure?']);
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
        'category_id' => [
            'sortable' => true,
        ],
        'name' => [
            'sortable' => true,
        ],
        'position' => [
            'sortable' => true,
        ],
    ]
]);
echo $dv->render();
