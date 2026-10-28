<?php

namespace restful\controllers;

use cnd\admin\models\activerecords\Log;
use common\models\Portfolio;
use Yii;
use cnd\core\api\SController;
use common\models\CountryProfile;

class CountryProfileController extends SController
{
    
    public function actionList($sectorUid = null)
    {
        $page = Yii::$app->request->get('page', 1);
        $pageSize = Yii::$app->request->get('pageSize', 25);
        $sort = Yii::$app->request->get('sort', 'name');
        $sortAttr = $sort;
        $sortDir = 'ASC';
        if (substr($sort, 0, 1) == '-') {
            $sortAttr = substr($sort, 1);
            $sortDir = 'DESC';
        }
        

    
        $query = CountryProfile::find();
    
     
        if ($sectorUid) {
            $portfolio = Portfolio::find()->where(['target' => Portfolio::TARGET_SECTOR, 'uid' => $sectorUid])->one();
            if ($portfolio) {
                $sector = $portfolio->sector;
                if ($sector) {
                    $query->andWhere(['sector_id' => $sector->id]);
                }
            }
        }
        $query->orderBy($sortAttr . ' ' . $sortDir);
        $query->limit($pageSize)->offset(($page - 1) * $pageSize);
       
       
    
        
        $list = $query->all();
        

        
        Log::trace("Download Country Profile List");
        
        return ['countryProfile' => $list];
    }
}
