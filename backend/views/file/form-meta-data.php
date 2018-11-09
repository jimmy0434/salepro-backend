<?php
/**
 * Created by PhpStorm.
 * User: JawdatSobh
 * Date: 09/11/2018
 * Time: 08:28
 *
 * @var $this View
 * @var $model File
 * @var $context FileController
 */

use backend\controllers\FileController;
use cnd\cms\models\activerecords\Category;
use cnd\form\ActiveForm;
use common\models\File;
use yii\web\View;
use yii\helpers\Html;

$isNew = $model->isNewRecord;

$this->title = ($isNew?'Add New File':'Update File').' Meta Data';
$context = $this->context;

$categories = Category::treeList();
$sectorRootId = Yii::$app->cms->getId("cms.category.sector.root");
$corporateRootId = Yii::$app->cms->getId("cms.category.corporate.root");
$brandRootId = Yii::$app->cms->getId("cms.category.brand.root");

$form = ActiveForm::begin(['id' => Yii::$app->controller->id.'-form']);
?>
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading"><?= ucfirst(Yii::$app->controller->id).' Form' ?></div>
                <div class="panel-body">
                    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
                    <?= $form->field($model, 'title')->textInput() ?>
                    <?= $form->field($model, 'status')->dropDownList($model->status_list) ?>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">Sectors</div>
                <div class="panel-body">
                    <?= isset($categories[$sectorRootId])?$form->field($model, 'sectors')->checkboxList(Category::dropDownList([$categories[$sectorRootId]]), ['multiple'=>true,'encode'=>false,'style'=>'height:400px;overflow:auto;','options'=>[]])->label(false):null ?>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">Corporates</div>
                <div class="panel-body">
                    <?= isset($categories[$corporateRootId])?$form->field($model, 'corporates')->checkboxList(Category::dropDownList([$categories[$corporateRootId]]), ['multiple'=>true,'encode'=>false,'style'=>'height:400px;overflow:auto;','options'=>[]])->label(false):null ?>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">Brands</div>
                <div class="panel-body">
                    <?= isset($categories[$brandRootId])?$form->field($model, 'brands')->checkboxList(Category::dropDownList([$categories[$brandRootId]]), ['multiple'=>true,'encode'=>false,'style'=>'height:400px;overflow:auto;','options'=>[]])->label(false):null ?>
                </div>
            </div>
        </div>
    </div>
    <?= $form->field($model, 'description')->editorInput() ?>
    <div class="form-group text-center">
        <?= Html::submitButton($isNew?'Next':'Save', ['class' => 'btn btn-primary btn-lg']) ?>
    </div>

<?php
ActiveForm::end();
$css = <<< CSS
#file-sectors label,#file-corporates label,#file-brands label{display:block !important;}
CSS;
$this->registerCss($css);

