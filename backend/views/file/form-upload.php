<?php
/**
 * Created by PhpStorm.
 * User: JawdatSobh
 * Date: 09/11/2018
 * Time: 09:28
 *
 * @var $this View
 * @var $model File
 * @var $context FileController
 */

use backend\controllers\FileController;
use cnd\admin\models\activerecords\Setting;
use common\models\File;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\View;
use cnd\form\ActiveForm;


$form = ActiveForm::begin(['id' => Yii::$app->controller->id . '-form']);
Yii::$app->notification->enabled = false;

$this->title = 'Manage File Upload';
$context = $this->context;
$extensions = Yii::$app->request->get('ext', Setting::get('file.allowed.extensions', 'pdf,png,jpg,mp4'));
$extensions = array_values(explode(',', $extensions));
$uploadUrl = Url::to(['file/manage-upload', 'id' => $model->id]);

?>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 style="margin: 0;padding: 0;">Upload File</h3>
                </div>
                <div class="panel-body">
                <b>Label</b>
                            <input type="text" id="namee" name="name" value="<?= $model->name ?>" >
                           <br>
                    <!-- Standar Form -->
                    <h4>Select file from your computer</h4>
                    <form action="" method="post" enctype="multipart/form-data" id="js-upload-form">
                        <div class="form-inline">
                            <div class="form-group">
                            
                       
                                 <input type="file" name="files" id="js-upload-files"
                                       accept="<?= implode(',', array_map(function ($item) {
                                           return '.' . $item;
                                       }, $extensions)) ?>">
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary" id="js-upload-submit">Start Upload
                            </button>
                        </div>
                    </form>

                    <!-- Drop Zone -->
                    <h4>Or drag and drop file below</h4>
                    <div class="upload-drop-zone" id="drop-zone">
                        Just drag and drop file here
                    </div>

                    <!-- Progress Bar -->
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0"
                             aria-valuemax="100" style="width: 0%;" id="progress">
                            <span class="sr-only">0% Complete</span>
                        </div>
                    </div>

                    <!-- Processing -->
                    <div class="alert alert-warning alert-processing">

                    </div>
                </div>
                <div class="panel-footer">
                    <span
                        class="badge bg-blue"><?= implode('</span>&nbsp;<span class="badge bg-blue">', $extensions) ?></span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 style="margin: 0;padding: 0;"><?= $model->title ?></h3>
                </div>
                <ul class="list-group">
                    <li class="list-group-item">
                        Status <span class="badge bg-red"><?= $model->status_label ?></span>
                    </li>
                    <li class="list-group-item">
                        Current version <span
                            class="badge bg-navy"><?= $model->version ? $model->version : 'no previous version' ?></span>
                    </li>
                    <li class="list-group-item">
                        Versions <span class="badge bg-teal"><?= $model->versionsCount ?></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
<?php
$exts = Json::encode($extensions);
$fileId = $model->id;
$fileName = $model->title;
$extension = $model->extension;

$filePartitionSize = Setting::get('file.upload.partition.size',1024 * 1024 * 1);
$ready = <<< JS
    let dropZone = document.getElementById('drop-zone');
    let uploadForm = document.getElementById('js-upload-form');
   
    uploadForm.addEventListener('submit', function(e) {
        let uploadFiles = document.getElementById('js-upload-files').files;
    
        e.preventDefault();
        startUpload(uploadFiles)
    });
    dropZone.ondrop = function(e) {
        e.preventDefault();
        this.className = 'upload-drop-zone';
        startUpload(e.dataTransfer.files);
    };
    dropZone.ondragover = function() {
        this.className = 'upload-drop-zone drop';
        return false;
    };
    dropZone.ondragleave = function() {
        this.className = 'upload-drop-zone';
        return false;
    };
JS;
$script = <<< JS
function startUpload(files){
    $('.alert-processing').hide().empty();
    if(files[0]){
        let file = files[0];
        let extensions = {$exts};   
        let ext = extension(file);
        if($.inArray(ext,extensions) > -1){
            msg("File Extension Valid");
            let maxStep = {$filePartitionSize};
            let steps = Math.ceil(file.size / maxStep);
            let step = file.size / steps;
            toChunks(file,step, function(chunks){
               uploadChunk(0, chunks, (new Date()).getTime(),ext);
            });
        }else{
            msg("file extension should be one of : "+extensions.join(', '));
        }
    }else{
        msg("Select a file!");
    }
}
function toChunks(file, step, done){
    msg("Start Loading File...");
    let total = file.size;
    let list = [];
    parseFile(file, step, function(content){
        list.push(content);
    }, function(){
        done(list);
    });
}
function extension(file){
    return file.name.split('.').pop().toLowerCase();
}
function parseFile(file,step, callback, done) {
    var fileSize   = file.size;
    var chunkSize  = step; // bytes
    var offset     = 0;
    var self       = this; // we need a reference to the current object
    var chunkReaderBlock = null;
    
    console.log(chunkSize);

    var readEventHandler = function(evt) {
        if (evt.target.error == null) {
            //offset += evt.target.result.length;
            offset += chunkSize;
            callback(evt.target.result); // callback for handling read chunk
        } else {
            msg("Read error: " + evt.target.error);
            return;
        }
        console.log(offset+' >= '+fileSize);
        if (offset >= fileSize) {
            msg("Done Loading");
            done();
            return;
        }

        // of to the next chunk
        chunkReaderBlock(offset, chunkSize, file);
    }

    chunkReaderBlock = function(_offset, length, _file) {
        var r = new FileReader();
        var blob = _file.slice(_offset, length + _offset);
        console.log(_offset,' , ', length + _offset,' # Blob length : ',blob);
        r.onload = readEventHandler;
        //r.readAsText(blob);
        //r.readAsBinaryString(blob);
        r.readAsDataURL(blob);
    }

    // now let's start the read with the first block
    chunkReaderBlock(offset, chunkSize, file);
}
function msg(text){
    $('.alert-processing').append('<p>'+text+'</p>').show();
}
function uploadChunk(index, chunks, version, extension){
  
    var test = $('#namee').val();

   
    if(index < chunks.length){
        
        $.ajax({
            type: 'post',
            url : '{$uploadUrl}',
            data: {
                version: version,
                chunk: chunks[index],
                order: index,
                count: chunks.length,
                extension, extension,
                name:test

            },
            dataType: 'json',
            beforeSend: function(){
                msg("Start uploading chunk "+(index+1)+'/'+chunks.length+' , version '+version );
            },
            success: function(response){
                uploadChunk(index+1, chunks, version, extension);
            },
            error: function(jqXHR, exception){
                let text = '';
                if (jqXHR.status === 0) {
                    text = 'Not connect, Verify Network.';
                } else if (jqXHR.status == 404) {
                    text = 'Requested page not found. [404]';
                } else if (jqXHR.status == 500) {
                    text = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    text = 'Requested JSON parse failed.';
                } else if (exception === 'timeout') {
                    text = 'Time out error.';
                } else if (exception === 'abort') {
                    text = 'Ajax request aborted.';
                } else {
                    text = 'Uncaught Error : ' + jqXHR.responseText;
                }
                msg(text);
                msg("Resend chunk "+(index+1)+'/'+chunks.length+' , version '+version);
                uploadChunk(index, chunks, version, extension);
            }
        });
    }else{
        msg("File was successfully uploaded");
        window.parent.popup.success("File was successfully uploaded");
        window.parent.postMessage(JSON.stringify({"id":"{$fileId}","name":"{$fileName}", "extension":"{$extension}"}), "*");
        window.setTimeout(function(){
            parent.$.fancybox.close();
        }, 500);
    }
}
JS;
$css = <<< CSS
.upload-drop-zone {
    height: 200px;
    border-width: 2px;
    margin-bottom: 20px;
}

.upload-drop-zone {
    color: #ccc;
    border-style: dashed;
    border-color: #ccc;
    line-height: 200px;
    text-align: center
}

.upload-drop-zone.drop {
    color: #222;
    border-color: #222;
}

.progress, .alert-processing {
    display: none;
}

.output {
    height: 450px;
    background: #222d32;
    overflow-x: hidden;
    overflow-y: auto;
}

.output .console {
    display: none;
    color: #00CC00;
}

.output .progress {
    display: none;
}
CSS;
$this->registerCss($css);
$this->registerJs($ready);
$this->registerJs($script, View::POS_END);
