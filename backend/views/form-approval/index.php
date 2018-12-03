<?php

/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 12/3/2018
 * Time: 10:15 AM
 *
 * @var $this \yii\web\View
 * @var $dataLocator \cnd\grid\DataLocator
 */

use cnd\grid\Attribute;
use cnd\grid\DataView;
use common\models\FormApprovalUser;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Manage Form Approve Request";

$context = $this->context;

$dv = new DataView([
    'dataLocator' => $dataLocator,
    'searchColumns' => DataView::SEARCH_COLUMNS_TWO,
    'attributes' => [
        'formApprovalUser.id' => [
            'label' => 'ID',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                /**
                 * @var $attribute Attribute
                 * @var $data FormApprovalUser
                 * @var $view DataView
                 */
                return str_pad($data->id, 8, '0', STR_PAD_LEFT);
            },
            'filterBy' => Attribute::FILTER_NUMBER,
        ],
        'formApprovalUser.user_id' => [
            'label' => 'User',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                /**
                 * @var $attribute Attribute
                 * @var $data FormApprovalUser
                 * @var $view DataView
                 */
                if(isset($data->user)) {
                    return $data->user->name;
                }
                return null;
            },
        ],
        'formApproval.form_id' => [
            'label' => 'Form',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                /**
                 * @var $attribute Attribute
                 * @var $data FormApprovalUser
                 * @var $view DataView
                 */
                if(isset($data->formApproval) && isset($data->formApproval->form)) {
                    return $data->formApproval->form->title;
                }
                return null;
            },
        ],
    ],
    'headerLinks' => [],
    'rowLinks' => [
        function ($row){
            if (Yii::$app->permission->can('/form-approval/view')) {
                return Html::a('View', Url::to(['view', 'id' => $row->id]), ['class' => 'btn btn-primary']);
            }
            return null;
        },
    ]
]);
$dv->addView('grid', [
    'class' => '\cnd\grid\GridTable',
    'columns' => [
        'formApprovalUser.id' => [
            'sortable' => true,
            'contentOptions' => [
                'style' => 'text-align:center;white-space: nowrap;width:1%;'
            ],
        ],
        'formApprovalUser.user_id' => [
            'sortable' => true,
        ],
        'formApproval.form_id' => [
            'sortable' => true,
        ],
    ]
]);
echo $dv->render();
