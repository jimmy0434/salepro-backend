<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 12/20/2018
 * Time: 8:42 AM
 *
 * @var $this View
 * @var $context ContentController
 */

use backend\controllers\ContentController;
use cnd\cms\models\activerecords\Content;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\JqueryAsset;
use yii\web\View;

$this->title = "Content Management";
$context = $this->context;

$contentHub = Json::encode(Yii::$app->cms->category->one("cms.category.contentHub"));
$marketIntelligence = Json::encode(Yii::$app->cms->category->one("cms.category.marketIntelligence"));
$competitor = Json::encode(Yii::$app->cms->category->one("cms.category.competitor"));
$brands = Json::encode(Yii::$app->cms->category->one("cms.category.brands"));
$corporates = Json::encode(Yii::$app->cms->category->one("cms.category.corporates"));
$sectors = Json::encode(Yii::$app->cms->category->one("cms.category.sectors"));
$brandsList = Json::encode(Yii::$app->cms->category->childOf("cms.category.brands")->all());
$corporatesList = Json::encode(Yii::$app->cms->category->childOf("cms.category.corporates")->all());
$sectorsList = Json::encode(Yii::$app->cms->category->childOf("cms.category.sectors")->all());

echo $this->render("content-manager", [], $context);
$saveCategoryUrl = Url::to(['/content/save-category']);
$UploadCategoryIconUrl = Url::to(['/content/upload-category-icon']);
$UploadContentCoverUrl = Url::to(['/content/upload-content-cover']);
$contentsUrl = Url::to(['/content/list']);
$statuses = Json::encode((new Content())->status_list);
$formBuilderUrl = Url::to(['/form/manage-structure', 'id' => '__ID__', 'dialog' => true]);
$fileUploadUrl = Url::to(['/file/manage-upload', 'id' => '__ID__', 'dialog' => true]);
$fileDownloadUrl = Url::to(['/file/download', 'id' => '__ID__']);
$manageContentUrl = Url::to(['/content/manage', 'id' => '__ID__', 'c' => '__C__']);
$createContentUrl = Url::to(['/content/create']);
$renameTitleUrl = Url::to(['/content/rename-title']);
$deleteContentUrl = Url::to(['/content/delete-content']);
$ready = <<< JS
contentManager('#content-manager', {
    contentHub: {$contentHub},
    marketIntelligence: {$marketIntelligence},
    competitor: {$competitor},
    brands: {$brands},
    corporates: {$corporates},
    sectors: {$sectors},
    brandsList: {$brandsList},
    corporatesList: {$corporatesList},
    sectorsList: {$sectorsList},
    saveCategoryUrl: '{$saveCategoryUrl}',
    UploadCategoryIconUrl: '{$UploadCategoryIconUrl}',
    UploadContentCoverUrl: '{$UploadContentCoverUrl}',
    contentsUrl: '{$contentsUrl}',
    formBuilderUrl: '{$formBuilderUrl}',
    fileUploadUrl: '{$fileUploadUrl}',
    fileDownloadUrl: '{$fileDownloadUrl}',
    manageContentUrl: '{$manageContentUrl}',
    createContentUrl: '{$createContentUrl}',
    renameTitleUrl: '{$renameTitleUrl}',
    deleteContentUrl: '{$deleteContentUrl}',
    statuses: {$statuses}
});
JS;

$this->registerJsFile(Yii::$app->helper->getAssetUrl('@bower/fancybox/dist/jquery.fancybox.js'), [
    'depends' => JqueryAsset::className(),
]);
$this->registerCssFile(Yii::$app->helper->getAssetUrl('@bower/fancybox/dist/jquery.fancybox.css'));

$this->registerJsFile(Yii::$app->helper->getAssetUrl('@npm/vue/dist/vue' . (YII_ENV_DEV ? '' : '.min') . '.js'), [
    'depends' => JqueryAsset::className(),
]);
$this->registerJsFile(Yii::$app->helper->getAssetUrl('@backend/assets/dist/js/vue-easycm.js'), [
    'depends' => JqueryAsset::className(),
]);
$this->registerJsFile(Yii::$app->helper->getAssetUrl('@backend/assets/dist/js/content-manager.js'), [
    'depends' => JqueryAsset::className(),
]);
$this->registerJs($ready);
$css = <<< CSS
#content-manager{position:relative; background:#fff; border-radius:3px;border:1px solid #ccc;display:flex;flex-direction:row;}
#content-manager .side-categories{min-height:600px; overflow:auto;border-right:1px solid #ccc; padding-right:10px;width:20%;min-width:25%;background:#f5f5f5;}
#content-manager .side-categories .root-node{padding:25px 0 25px 8px;}
#content-manager .grid-contents{flex:auto; padding:25px;}
#content-manager .item { cursor: pointer;}
#content-manager .item .file{overflow:hidden;}
#content-manager .item .folder{  font-weight:bold;}
#content-manager .item .file:not(.folder){ line-height:25px; padding-left:7px; border-radius:3px; border:1px solid transparent;}
#content-manager .item .file:not(.folder):hover,
#content-manager .item .file:not(.folder):focus{ background:#e5e5e5; border:1px solid #ccc;}
#content-manager .item .file .glyphicon{font-weight: 100;}
#content-manager .item .file > input[type=file]{position:absolute;left:-1000px;}
#content-manager ul { padding-left: 1em; line-height: 1.5em; }
#content-manager ul li{list-style:none;}
#content-manager .input-new{position:relative;}
#content-manager .input-new .form-control{border:none; background:transparent;height:25px; line-height:25px; padding:0 7px;}
#content-manager .input-new .form-control.edit-input{padding:0;}
#content-manager .cm-container .cm-ul{padding:0;box-shadow: 0 0 1px #666;}
#content-manager .thumbnail-fixes{position:relative;overflow:hidden;}
#content-manager .thumbnail-fixes .img{height: 150px;background-size: auto 100%;background-position: center;background-repeat: no-repeat;background-color:#f0f0f0;position:relative;overflow:hidden;}
#content-manager .thumbnail-fixes .img .target{position:absolute;bottom:2px;left:2px; display:block; padding:5px; background:rgba(0,0,0,0.5); color:#fff;border-radius:3px;}
#content-manager .thumbnail-fixes .img .status{position:absolute;bottom:2px;right:2px; display:block; padding:5px; background:rgba(0,0,0,0.5); color:#fff;border-radius:3px;}
#content-manager .thumbnail-fixes input[type=file]{position:absolute;left:-1000px;}
#content-manager .grid-contents .input-add-new{position:fixed;top:0;left:0;width:100%;height:100%;z-index:9901;background:rgba(0,0,0,0.5);}
#content-manager .grid-contents .input-add-new .add-new-box{position:fixed;top:50%;left:50%;max-width:600px; width:90%;transform: translate(-50%,-50%);z-index:1;border-radius:3px;border:2px solid rgba(0,0,0,0.8);background:#fff;padding:25px;}
#content-manager .grid-contents .input-add-new .add-new{height:50px;line-height:50px;padding:0 15px;font-size:24px;}
CSS;
$this->registerCss($css);