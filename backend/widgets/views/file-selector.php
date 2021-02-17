<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 1/25/2019
 * Time: 11:18 AM
 *
 * @var $this View
 * @var $file File
 * @var $model ActiveRecord
 * @var $property string
 * @var $fileId integer
 * @var $context FileSelector
 * @var $title string
 * @var $fileName string
 * @var $ext string
 */

use backend\widgets\FileSelector;
use cnd\core\components\ActiveRecord;
use common\models\File;
use yii\helpers\Html;
use yii\web\JqueryAsset;
use yii\web\View;

$context = $this->context;
$fileExtension = null;
if($file) {
    $fileExtension = $file->extension;
    $fileName = $file->title;
}
?>
    <div class="file-selector">
        <h3 class="header">
            <?= $title ?>
            <?php

            if($fileId) echo Html::a('<span class="glyphicon glyphicon-eye-open"></span>', array('file/download', 'id'=>$fileId), ['target'=>'_blank']);
            ?>
        </h3>
        
        <?php
     
        $hid = Html::getInputId($model, $property);
      
     
        echo Html::activeHiddenInput($model, $property, ['id' => $hid]);
    
        echo Html::a('', ['/file/popup-management', 'id' => $fileId, 'title' => $fileName, 'ext' => $ext,'name'=>$name], ['class' => 'thumbnail text-center', 'data' => [
            'fancybox' => true,
            'type' => 'iframe',
        ], 'id' => 'v-' . $hid]);
        $error = Html::error($model, $property,['class'=>'text-red']);
        if($error){
            echo $error;
        }
        ?>
    </div>
<?php
$this->registerJsFile(Yii::$app->helper->getAssetUrl('@bower/fancybox/dist/jquery.fancybox.js'), [
    'depends' => JqueryAsset::className(),
]);
$this->registerCssFile(Yii::$app->helper->getAssetUrl('@bower/fancybox/dist/jquery.fancybox.css'));
$ready = <<< JS
if('{$fileId}'){
    $('#v-{$hid}').html("{$fileName}.{$fileExtension}");
}else{
    $('#v-{$hid}').html("Select {$title}");
}
// Create IE + others compatible event handler
var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
var eventer = window[eventMethod];
var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message";

// Listen to message from child window
eventer(messageEvent,function(e) {
    let data = JSON.parse(e.data);
    if(data.name === "{$fileName}"){
        data.id = parseInt(data.id);
        $('#{$hid}').val(data.id);
        $('#v-{$hid}').html(data.name + "." + data.extension);
    }
},false);
JS;
$this->registerJs($ready);

