<?php


namespace restful\controllers;


use cnd\admin\models\activerecords\Log;
use cnd\core\api\SController;
use common\models\File;
use common\models\Learning;
use common\models\LearningQuery;


class LearningController extends SController
{


    public function actionView1()
    {
        $query = Learning::find();
        $query->where(['learning.target' => '1']);
        $query->from(['learning' => Learning::tableName()]);
      
        $query->orderBy('learning.name ASC');
        
        return [
            'learn' =>$query->all(),
           
        ];
    }

    
    public function actionChild($id)
    {
        $query = Learning::find();
        $query->where(['learning.parent_id' => $id]);
        $query->from(['learning' => Learning::tableName()]);
      
        $query->orderBy('learning.name ASC');
        
        return [
            'learn' =>$query->all(),
           
        ];
    }
 


}
