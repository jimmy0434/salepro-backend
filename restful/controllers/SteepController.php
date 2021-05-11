<?php


namespace restful\controllers;

use cnd\admin\models\activerecords\Log;
use common\models\Steep;
use Yii;
use cnd\core\api\SController;


class SteepController extends SController
{
   
    public function actionSocials()
    {
        $target='1';
        $page = Yii::$app->request->get('page', 1);
        $pageSize = Yii::$app->request->get('pageSize', 25);
        $sort = Yii::$app->request->get('sort', 'name');
        $sortAttr = $sort;
        $sortDir = 'ASC';
        if (substr($sort, 0, 1) == '-') {
            $sortAttr = substr($sort, 1);
            $sortDir = 'DESC';
        }
        

    
        $query = Steep::find()->where(['target'=>$target]);
    
     
        $query->orderBy($sortAttr . ' ' . $sortDir);
        $query->limit($pageSize)->offset(($page - 1) * $pageSize);
       
       
    
        
        $list = $query->all();
        

        
        Log::trace("Download steep social List");
        
        return ['steep' => $list];
    }
    public function actionTechnologicals()
    {
        $target='2';
        $page = Yii::$app->request->get('page', 1);
        $pageSize = Yii::$app->request->get('pageSize', 25);
        $sort = Yii::$app->request->get('sort', 'name');
        $sortAttr = $sort;
        $sortDir = 'ASC';
        if (substr($sort, 0, 1) == '-') {
            $sortAttr = substr($sort, 1);
            $sortDir = 'DESC';
        }
        

    
        $query = Steep::find()->where(['target'=>$target]);
    
     
        $query->orderBy($sortAttr . ' ' . $sortDir);
        $query->limit($pageSize)->offset(($page - 1) * $pageSize);
       
       
    
        
        $list = $query->all();
        

        
        Log::trace("Download steep technological List");
        
        return ['steep' => $list];
    }
    public function actionEconomicals()
    {
        $target='3';
        $page = Yii::$app->request->get('page', 1);
        $pageSize = Yii::$app->request->get('pageSize', 25);
        $sort = Yii::$app->request->get('sort', 'name');
        $sortAttr = $sort;
        $sortDir = 'ASC';
        if (substr($sort, 0, 1) == '-') {
            $sortAttr = substr($sort, 1);
            $sortDir = 'DESC';
        }
        

    
        $query = Steep::find()->where(['target'=>$target]);
    
     
        $query->orderBy($sortAttr . ' ' . $sortDir);
        $query->limit($pageSize)->offset(($page - 1) * $pageSize);
       
       
    
        
        $list = $query->all();
        

        
        Log::trace("Download steep economical List");
        
        return ['steep' => $list];
    }
    public function actionEcologicals()
    {
        $target='4';
        $page = Yii::$app->request->get('page', 1);
        $pageSize = Yii::$app->request->get('pageSize', 25);
        $sort = Yii::$app->request->get('sort', 'name');
        $sortAttr = $sort;
        $sortDir = 'ASC';
        if (substr($sort, 0, 1) == '-') {
            $sortAttr = substr($sort, 1);
            $sortDir = 'DESC';
        }
        

    
        $query = Steep::find()->where(['target'=>$target]);
    
     
        $query->orderBy($sortAttr . ' ' . $sortDir);
        $query->limit($pageSize)->offset(($page - 1) * $pageSize);
       
       
    
        
        $list = $query->all();
        

        
        Log::trace("Download steep ecological List");
        
        return ['steep' => $list];
    }
    public function actionPoliticals()
    {
        $target='5';
        $page = Yii::$app->request->get('page', 1);
        $pageSize = Yii::$app->request->get('pageSize', 25);
        $sort = Yii::$app->request->get('sort', 'name');
        $sortAttr = $sort;
        $sortDir = 'ASC';
        if (substr($sort, 0, 1) == '-') {
            $sortAttr = substr($sort, 1);
            $sortDir = 'DESC';
        }
        

    
        $query = Steep::find()->where(['target'=>$target]);
    
     
        $query->orderBy($sortAttr . ' ' . $sortDir);
        $query->limit($pageSize)->offset(($page - 1) * $pageSize);
       
       
    
        
        $list = $query->all();
        

        
        Log::trace("Download steep politicals List");
        
        return ['steep' => $list];
    }
}
