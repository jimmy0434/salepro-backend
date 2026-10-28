<?php


namespace restful\controllers;

use cnd\admin\models\activerecords\Log;
use Yii;
use cnd\core\api\SController;
use common\models\Pactgalery;

class PactgaleryController extends SController
{

    
    public function actionList()
    {
        $page = Yii::$app->request->get('page', 1);
        $pageSize = Yii::$app->request->get('pageSize', 25);

        $query = Pactgalery::find();
        $query->orderBy('name ASC');
        $query->limit($pageSize)->offset(($page - 1) * $pageSize);
        $list = $query->all();
        Log::trace("Download Pact Glerys List");
        return ['pactgaleries' => $list];
    }

}
