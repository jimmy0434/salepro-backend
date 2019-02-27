<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 2/27/2019
 * Time: 10:26 AM
 */

use backend\controllers\CertificationController;
use cnd\grid\Attribute;
use cnd\grid\DataView;
use cnd\grid\DataViewLocator;
use common\models\Certification;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use cnd\grid\DataLocator;

$view = $this;
$context = $this->context;

assert($view instanceof View);
assert($dataLocator instanceof DataLocator);
assert($context instanceof CertificationController);

$this->title = "Certification Management";

$dv = new DataView([
    'dataLocator' => $dataLocator,
    'searchColumns' => DataView::SEARCH_COLUMNS_TWO,
    'attributes' => [
        'id' => [
            'label' => 'ID',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof Certification);
                assert($view instanceof DataViewLocator);
                return str_pad($data->id, 8, '0', STR_PAD_LEFT);
            },
            'filterBy' => Attribute::FILTER_NUMBER,
        ],
        'image' => [
            'label' => 'Image',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof Certification);
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
        'name' => [
            'label' => 'Name',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof Certification);
                assert($view instanceof DataViewLocator);
                return $data->name;
            },
        ],
    ],
    'headerLinks' => [
        Yii::$app->permission->can('/certification/manage') ? Html::a('Add New', Url::to(['manage']), ['class' => 'btn btn-success']) : null,
    ],
    'rowLinks' => [
        function ($row) {
            if (Yii::$app->permission->can('/certification/manage')) {
                return Html::a('Edit', Url::to(['manage', 'id' => $row->id]), ['class' => 'btn btn-info']);
            }
            return null;
        },
        function ($row) {
            if (Yii::$app->permission->can('/certification/delete')) {
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
        'name' => [
            'sortable' => true,
        ],
    ]
]);
echo $dv->render();
