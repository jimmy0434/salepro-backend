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

    public function actionDownload(){
        $fileId = Yii::$app->request->post('id');
        $version = Yii::$app->request->post('version');
        $order = Yii::$app->request->post('order', 0);
        $partition = FilePartition::find()->where(['file_id'=>$fileId,'version'=>$version,'order'=>$order])->one();
        $partition->data = base64_encode($partition->data);
        return ['partition' => $partition];
    }
}