<?php


namespace restful\controllers;

use cnd\admin\models\activerecords\Log;
use common\models\Directory;
use Yii;
use cnd\core\api\SController;


class DirectoryController extends SController
{
   
    public function actionList()
    {
        
        $page = Yii::$app->request->get('page', 1);
        $pageSize = Yii::$app->request->get('pageSize', 25);
        $query = Directory::find();
        $query->limit($pageSize)->offset(($page - 1) * $pageSize);

        $query->orderBy('id DESC');
        
        $list = $query->all();
        Log::trace("Download Directory List");
        return ['directory' => $list];
    }
  
}
