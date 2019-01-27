<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 1/26/2019
 * Time: 11:34 AM
 */

namespace restful\controllers;


use cnd\core\api\SController;
use common\models\File;
use common\models\Portfolio;

class PortfolioController extends SController
{
    /**
     * @SWG\Get(
     *     path="/portfolios",
     *     tags={"Portfolio"},
     *     summary="Retrieves the collection of portfolios resources.",
     *     @SWG\Response(
     *         response = 200,
     *         description = "Portfolios collection response"
     *     ),
     *     security = {{"Bearer": {}}},
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer TOKEN", description="Authorization" )
     * )
     */

    public function actionList()
    {
        $corporates = $this->list(Portfolio::TARGET_CORPORATE);
        $brands = $this->list(Portfolio::TARGET_BRAND);
        $sectors = $this->list(Portfolio::TARGET_SECTOR);

        return [
            'corporates' => $corporates,
            'brands' => $brands,
            'sectors' => $sectors,
        ];
    }

    protected function list($target)
    {
        $query = Portfolio::find();
        $query->where(['target' => $target]);
        $query->from(['portfolio' => Portfolio::tableName()]);
        $query->joinWith([
            'brochure' => function ($query) {
                $query->from(['brochure' => File::tableName()]);
            },
            'presentation' => function ($query) {
                $query->from(['presentation' => File::tableName()]);
            },
            'video' => function ($query) {
                $query->from(['video' => File::tableName()]);
            }
        ], false);
        return $query->all();
    }

    /**
     * @SWG\Get(
     *     path="/portfolios/{uid}",
     *     tags={"Portfolio"},
     *     summary="Retrieves portfolio resources",
     *     @SWG\Response(
     *         response = 200,
     *         description = "Portfolio response"
     *     ),
     *     security = {{"Bearer": {}}},
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer TOKEN", description="Authorization" ),
     *     @SWG\Parameter(name="uid", required=true, in="path", type="string", description="The Portfolio UID")
     * )
     */
    public function actionOne($uid)
    {
        $query = Portfolio::find();
        $query->where(['uid' => $uid]);
        $model = $query->one();
        return ['portfolio' => $model];
    }
}