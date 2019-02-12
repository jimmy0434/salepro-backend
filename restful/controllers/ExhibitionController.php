<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 2/12/2019
 * Time: 8:27 AM
 */

namespace restful\controllers;


use cnd\core\api\SController;
use common\models\Exhibition;

class ExhibitionController extends SController
{

    /**
     * @SWG\Get(
     *     path="/exhibitions",
     *     tags={"Portfolio"},
     *     summary="Retrieves exhibitions resources.",
     *     @SWG\Response(
     *         response = 200,
     *         description = "exhibitions response"
     *     ),
     *     security = {{"Bearer": {}}},
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer TOKEN", description="Authorization" ),
     *     @SWG\Parameter(name="page", required=true, in="query", type="integer", description="Page start from 1", default=1),
     *     @SWG\Parameter(name="pageSize", required=true, in="query", type="integer", description="Page Size default 25", default=25)
     * )
     */
    public function actionList()
    {
        $page = Yii::$app->request->get('page', 1);
        $pageSize = Yii::$app->request->get('pageSize', 25);

        $query = Exhibition::find();
        $query->orderBy('name ASC');
        $query->limit($pageSize)->offset(($page - 1) * $pageSize);
        $list = $query->all();
        return ['exhibitions' => $list];
    }

}
