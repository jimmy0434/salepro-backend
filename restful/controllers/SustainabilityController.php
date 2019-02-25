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

use cnd\admin\models\activerecords\Setting;
use Yii;
use cnd\core\api\SController;
use common\models\Sustainability;
use yii\helpers\ArrayHelper;

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
     *     @SWG\Parameter(name="pageSize", required=false, in="query", type="integer", description="Page Size default 250", default=250)
     * )
     */
    public function actionList()
    {
        $page = Yii::$app->request->get('page', 1);
        $pageSize = Yii::$app->request->get('pageSize', 250);

        $query = Sustainability::find();
        $query->limit($pageSize)->offset(($page - 1) * $pageSize);
        $query->orderBy('position ASC, name ASC');
        $list = ArrayHelper::map($query->all(),'id', function($model){
            return $model;
        },'type');
        $title = Setting::get('sustainability.title','');
        $text = Setting::get('sustainability.text','');
        return ['sustainability' => $list,'title'=>$title, 'text'=>$text];
    }
}
