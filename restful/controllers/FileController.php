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
use Swagger\Annotations as SWG;

class FileController extends SController
{
    /**
     * @SWG\Get(
     *     path="/files/{id}/download/{version}/{order}",
     *     tags={"Cms"},
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
    public function actionDownload($id, $version, $order = 0){
        $partition = FilePartition::find()->where(['file_id'=>$id,'version'=>$version,'order'=>$order])->one();
        $partition->data = base64_encode($partition->data);
        Log::trace("Download Partition number #".$order." of file #".$id." , version #".$version);
        return ['partition' => $partition];
    }
}