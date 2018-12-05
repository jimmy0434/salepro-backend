<?php
/**
 * Created by PhpStorm.
 * User: JawdatSobh
 * Date: 12/11/2018
 * Time: 14:32
 */

namespace restful\controllers;

use cnd\admin\models\activerecords\Log;
use common\models\FilePartition;
use cnd\core\api\SController;

class FileController extends SController
{

    public function actionDownload($id, $version, $order = 0){
        $partition = FilePartition::find()->where(['file_id'=>$id,'version'=>$version,'order'=>$order])->one();
        $partition->data = base64_encode($partition->data);
        Log::trace("Download Partition number #".$order." of file #".$id." , version #".$version);
        return ['partition' => $partition];
    }
}