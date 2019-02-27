<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 2/4/2019
 * Time: 3:00 PM
 */

use backend\widgets\CustomSetting;
use cnd\grid\Attribute;
use cnd\grid\DataView;
use cnd\grid\DataViewLocator;
use common\models\Sustainability;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use cnd\grid\DataLocator;
use backend\controllers\SustainabilityController;

$view = $this;
$context = $this->context;

assert($view instanceof View);
assert($dataLocator instanceof DataLocator);
assert($context instanceof SustainabilityController);

$this->title = "Sustainability Management";

?>
<div class="btn-group btn-group-justified" role="group" aria-label="targets">
    <?php
    foreach ($context->types as $value => $label) {
        echo Html::a($label, ['index', 't' => $value], ['class' => 'btn btn-default ' . ($value == $context->type ? 'active' : '')]);
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
                assert($data instanceof Sustainability);
                assert($view instanceof DataViewLocator);
                return str_pad($data->id, 8, '0', STR_PAD_LEFT);
            },
            'filterBy' => Attribute::FILTER_NUMBER,
        ],
        'image' => [
            'label' => 'Image',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof Sustainability);
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
        'position' => [
            'label' => 'Position',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof Sustainability);
                assert($view instanceof DataViewLocator);
                return $data->position;
            },
            'filterBy' => Attribute::FILTER_NUMBER,
        ],
        'name' => [
            'label' => 'Name',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                assert($attribute instanceof Attribute);
                assert($data instanceof Sustainability);
                assert($view instanceof DataViewLocator);
                return $data->name;
            },
        ],
    ],
    'headerLinks' => [
        Yii::$app->permission->can('/sustainability/manage') ? Html::a('Add New', Url::to(['manage','t'=>$context->type]), ['class' => 'btn btn-success']) : null,
    ],
    'rowLinks' => [
        function ($row) use($context) {
            if (Yii::$app->permission->can('/sustainability/manage')) {
                return Html::a('Edit', Url::to(['manage', 'id' => $row->id,'t'=>$context->type]), ['class' => 'btn btn-info']);
            }
            return null;
        },
        function ($row) use($context) {
            if (Yii::$app->permission->can('/sustainability/delete')) {
                return Html::a('Delete', Url::to(['delete', 'id' => $row->id,'t'=>$context->type]), ['class' => 'btn btn-danger', 'data-confirm' => 'Are You Sure?']);
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
        'position' => [
            'sortable' => true,
        ],
    ]
]);
echo $dv->render();

?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h2>Information</h2>
    </div>
    <div class="panel-body">
        <?php
        echo CustomSetting::widget([
            'name' => 'sustainability.title',
            'title' => 'Title',
        ]);
        echo '<hr>';
        echo CustomSetting::widget([
            'name' => 'sustainability.text',
            'title' => 'Content',
            'input' => function($form, $model, $attribute, $options){
                return $form->field($model, $attribute)->editorInput($options);
            }
        ]);
        ?>
    </div>
</div>
