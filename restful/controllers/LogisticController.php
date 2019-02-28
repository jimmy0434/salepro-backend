<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 2/26/2019
 * Time: 9:32 AM
 */

namespace restful\controllers;


use cnd\admin\models\activerecords\Log;
use cnd\core\api\SController;
use common\models\LogisticCategory;

class LogisticController extends SController
{

    /**
     * @SWG\Get(
     *     path="/logistics",
     *     tags={"Portfolio"},
     *     summary="Logistics",
     *     @SWG\Response(
     *         response = 200,
     *         description = "Logistics Response"
     *     ),
     *     security = {{"Bearer": {}}},
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer TOKEN", description="Authorization" )
     * )
     */
    public function actionList()
    {
        $query = LogisticCategory::find();
        $query->orderBy(['position' => SORT_ASC, 'name' => SORT_ASC]);
        $list = $query->all();
        Log::trace("Download Logistics List");
        return ['logistics' => $list];
    }

}
