<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 1/29/2019
 * Time: 2:08 PM
 */

namespace restful\controllers;

use cnd\admin\models\activerecords\Log;
use common\models\Portfolio;
use Yii;
use cnd\core\api\SController;
use common\models\MarketResearch;

class MarketResearchController extends SController
{
    /**
     * @SWG\Get(
     *     path="/market-research",
     *     tags={"Portfolio"},
     *     summary="Retrieves market research resources.",
     *     @SWG\Response(
     *         response = 200,
     *         description = "market research response"
     *     ),
     *     security = {{"Bearer": {}}},
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer TOKEN", description="Authorization" ),
     *     @SWG\Parameter(name="page", required=true, in="query", type="integer", description="Page start from 1", default=1),
     *     @SWG\Parameter(name="pageSize", required=true, in="query", type="integer", description="Page Size default 25", default=25),
     *     @SWG\Parameter(name="sort", required=false, in="query", type="string", description="sort attribute name, prefix with minus `-` to DESC")
     * )
     */
    /**
     * @SWG\Get(
     *     path="/sectors/{uid}/market-research",
     *     tags={"Portfolio"},
     *     summary="Retrieves market research resources of sector.",
     *     @SWG\Response(
     *         response = 200,
     *         description = "market research response"
     *     ),
     *     security = {{"Bearer": {}}},
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer TOKEN", description="Authorization" ),
     *     @SWG\Parameter(name="page", required=true, in="query", type="integer", description="Page start from 1", default=1),
     *     @SWG\Parameter(name="pageSize", required=true, in="query", type="integer", description="Page Size default 25", default=25),
     *     @SWG\Parameter(name="sort", required=false, in="query", type="string", description="sort attribute name, prefix with minus `-` to DESC"),
     *     @SWG\Parameter(name="uid", required=true, in="path", type="string", description="The Sector Portfolio UID")
     * )
     */
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
        

    
        $query = MarketResearch::find();
     
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
        

        
        Log::trace("Download Market Research List");
        
        return ['marketResearch' => $list];
    }
}
