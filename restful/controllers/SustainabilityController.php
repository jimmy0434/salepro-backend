<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 2/4/2019
 * Time: 4:25 PM
 */

namespace restful\controllers;

use Yii;
use cnd\core\api\SController;
use common\models\Sustainability;

class SustainabilityController extends SController
{
    /**
     * @SWG\Get(
     *     path="/sustainability",
     *     tags={"Portfolio"},
     *     summary="Sustainability Tiles",
     *     @SWG\Response(
     *         response = 200,
     *         description = "Sustainability Tiles Response"
     *     ),
     *     security = {{"Bearer": {}}},
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer TOKEN", description="Authorization" ),
     *     @SWG\Parameter(name="page", required=false, in="query", type="integer", description="Page start from 1", default=1),
     *     @SWG\Parameter(name="pageSize", required=false, in="query", type="integer", description="Page Size default 25", default=25)
     * )
     */
    public function actionList()
    {
        $page = Yii::$app->request->get('page', 1);
        $pageSize = Yii::$app->request->get('pageSize', 25);

        $query = Sustainability::find();
        $query->limit($pageSize)->offset(($page - 1) * $pageSize);
        $query->orderBy('name ASC');
        $list = $query->all();
        return ['sustainability' => $list];
    }
}
