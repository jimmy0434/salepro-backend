<?php


use backend\controllers\SteepController;
use cnd\grid\Attribute;
use cnd\grid\DataLocator;
use cnd\grid\DataView;
use cnd\grid\DataViewLocator;
use common\models\Steep;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\Url;
use yii\web\View;

$context = $this->context;

$this->title = "Steep Management | " . $context->targets[$context->target];


?>
    <div class="btn-group btn-group-justified" role="group" aria-label="targets">
        <?php
        foreach ($context->targets as $value => $label) {
            echo Html::a($label . 's', ['index', 't' => $value], ['class' => 'btn btn-default ' . ($value == $context->target ? 'active' : '')]);
        }
        ?>
    </div>
    <hr>
<?php
$extraLinks = [];


$dv = new DataView([
    'dataLocator' => $dataLocator,
    'searchColumns' => DataView::SEARCH_COLUMNS_TWO,
    'attributes' => [
        'id' => [
            'label' => 'ID',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                /**
                 * @var $attribute Attribute
                 * @var $data Steep
                 * @var $view DataView
                 */
                return str_pad($data->id, 8, '0', STR_PAD_LEFT);
            },
            'filterBy' => Attribute::FILTER_NUMBER,
        ],
       
        'name' => [
            'label' => 'Name',
            'value' => function ($attribute, $data, $view) use ($dataLocator) {
                /**
                 * @var $attribute Attribute
                 * @var $data Steep
                 * @var $view DataView
                 */
                return $data->name;
            },
        ],
   
      
        'updated_at' => [
            'label' => 'Last Modification',
            'value' => function ($attribute, $data, $view) {
                assert($attribute instanceof Attribute);
                assert($data instanceof Steep);
                assert($view instanceof DataViewLocator);
                return date('l, d F, Y H:i',$data->updated_at);
            },
            'filterBy' => Attribute::FILTER_NONE,
        ],
    ],
    'headerLinks' => [
        Yii::$app->permission->can('/steep/manage') ? Html::a('Add New', Url::to(['manage', 't' => $context->target]), ['class' => 'btn btn-success']) : null,
    ],
    'rowLinks' => array_merge($extraLinks, [
        function ($row) use ($context) {
            if (Yii::$app->permission->can('/steep/manage')) {
                return Html::a('Edit', Url::to(['manage', 'id' => $row->id, 't' => $context->target]), ['class' => 'btn btn-primary']);
            }
            return null;
        },
        function ($row) use ($context) {
            if (Yii::$app->permission->can('/steep/delete')) {
                return Html::a('Delete', Url::to(['delete', 'id' => $row->id, 't' => $context->target]), ['class' => 'btn btn-danger', 'data-confirm' => 'Are You Sure?']);
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
echo $dv->render();


