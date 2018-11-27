<?php
/**
 * Created by PhpStorm.
 * User: JawdatSobh
 * Date: 12/11/2018
 * Time: 14:32
 */

namespace restful\controllers;

use common\models\File;
use common\models\FilePartition;
use Yii;
use cnd\core\api\SController;
use yii\db\Expression;

class FileController extends SController
{

    public function actionDownload($id, $version, $order = 0){
        $partition = FilePartition::find()->where(['file_id'=>$id,'version'=>$version,'order'=>$order])->one();
        $partition->data = base64_encode($partition->data);
        return ['partition' => $partition];
    }
}