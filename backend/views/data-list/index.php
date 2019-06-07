<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 2/6/2019
 * Time: 4:03 PM
 */

use backend\controllers\DataListController;
use cnd\grid\Attribute;
use cnd\grid\DataView;
use cnd\grid\DataViewLocator;
use common\models\DataList;
use Doctrine\Common\Inflector\Inflector;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use cnd\grid\DataLocator;

$view = $this;
$context = $this->context;

assert($view instanceof View);
assert($dataLocator instanceof DataLocator);
assert($context instanceof DataListController);

$this->title = "Data List Management | " . Inflector::pluralize($context->types[$context->type]);

$children = [];
if ($context->type == DataList::TYPE_PRODUCTION_LINE) {
    $children[] = function ($row) use ($context) {
        if (Yii::$app->permission->can('/data-list/index')) {
            return Html::a('Brands', Url::to(['index', 't' => DataList::TYPE_LINE_BRAND, 'u' => $row->id]), ['class' => 'btn btn-warning']);
        }
        return null;
    };
}

$dv = new DataView([
    'dataLocator' => $dataLocator,
    'searchColumns' => DataView::SEARCH_COLUMNS_TWO,
    'attributes' => [
        'id' => [
            'label' => 'ID',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof DataList);
                assert($view instanceof DataViewLocator);
                return str_pad($data->id, 8, '0', STR_PAD_LEFT);
            },
            'filterBy' => Attribute::FILTER_NUMBER,
        ],
        'name' => [
            'label' => 'Name',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof DataList);
                assert($view instanceof DataViewLocator);
                return $data->name;
            },
        ],
        'updated_at' => [
            'label' => 'Last Modification',
            'value' => function ($attribute, $data, $view) {
                assert($attribute instanceof Attribute);
                assert($data instanceof DataList);
                assert($view instanceof DataViewLocator);
                return date('l, d F, Y H:i',$data->updated_at);
            },
            'filterBy' => Attribute::FILTER_NONE,
        ],
    ],
    'headerLinks' => [
        Yii::$app->permission->can('/data-list/manage') ? Html::a('Add New', Url::to(['manage', 't' => $context->type, 'u' => $context->up]), ['class' => 'btn btn-success']) : null,
    ],
    'rowLinks' => array_merge($children, [
        function ($row) use ($context) {
            if (Yii::$app->permission->can('/data-list/manage')) {
                return Html::a('Edit', Url::to(['manage', 'id' => $row->id, 't' => $context->type, 'u' => $context->up]), ['class' => 'btn btn-info']);
            }
            return null;
        },
        function ($row) use ($context) {
            if (Yii::$app->permission->can('/data-list/delete')) {
                return Html::a('Delete', Url::to(['delete', 'id' => $row->id, 't' => $context->type, 'u' => $context->up]), ['class' => 'btn btn-danger', 'data-confirm' => 'Are You Sure?']);
            }
            return null;
        },
    ]),
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
        'updated_at' => [
            'sortable' => true,
            'contentOptions' => [
                'style' => 'text-align:center;white-space: nowrap;width:1%;'
            ],
        ],
    ]
]);
?>
<div class="row">
    <div class="col-md-3">
        <div class="list-group">
            <?php
            foreach ($context->types as $value => $label) {
                if ($value != DataList::TYPE_LINE_BRAND) {
                    echo Html::a($label, ['index', 't' => $value], ['class' => 'list-group-item' . ($value == $context->type ? ' active' : '')]);
                }else if($value == DataList::TYPE_LINE_BRAND && $context->type == DataList::TYPE_LINE_BRAND){
                    echo Html::tag('div', $label, ['class'=>'list-group-item active']);
                }
            }
            ?>
        </div>
    </div>
    <div class="col-md-9">
        <?= $dv->render() ?>
    </div>
</div>
