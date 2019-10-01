<?php
/**
 * Created by PhpStorm.
 * User: JawdatSobh
 * Date: 12/11/2018
 * Time: 14:32
 */

namespace restful\controllers;

use common\models\File;
use Yii;
use cnd\admin\models\activerecords\Log;
use common\models\FilePartition;
use cnd\core\api\SController;
use Swagger\Annotations as SWG;

class FileController extends SController
{
    /**
     * @SWG\Get(
     *     path="/files/{id}/download/{version}/{order}",
     *     tags={"File"},
     *     summary="Download file partition",
     *     @SWG\Response(
     *         response = 200,
     *         description = "File Partition Content",
     *         @SWG\Schema(ref = "#/definitions/FilePartition")
     *     ),
     *     security = {{"Bearer": {}}},
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer TOKEN", description="Authorization" ),
     *
     *     @SWG\Parameter(name="id", required=true, in="path", type="integer", description="The File ID"),
     *     @SWG\Parameter(name="version", required=true, in="path", type="integer", description="The File Version"),
     *     @SWG\Parameter(name="order", required=true, in="path", type="integer", description="Order Of Partition start from 0")
     * )
     */
    public function actionDownload($id, $version, $order = 0)
    {
        $partition = FilePartition::find()->where(['file_id' => $id, 'version' => $version, 'order' => $order])->one();
        $secretKey = Yii::$app->secretKey($partition->file_id, $partition->order);
        $partition->data = base64_encode(Yii::$app->getSecurity()->decryptByPassword($partition->data, $secretKey));
        Log::trace("Download Partition number #" . $order . " of file #" . $id . " , version #" . $version);
        return ['partition' => $partition];
    }

    /**
     * @SWG\Get(
     *     path="/files",
     *     tags={"File"},
     *     summary="Download all files list",
     *     @SWG\Response(
     *         response = 200,
     *         description = "File Content",
     *         @SWG\Schema(ref = "#/definitions/File")
     *     ),
     *     security = {{"Bearer": {}}},
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer TOKEN", description="Authorization" )
     * )
     */
    public function actionAll()
    {
        Log::trace("Download all files");
        $all = File::find()->where(['status'=>File::STATUS_ACTIVE])->all();
        return ["files" => $all];
    }
}
