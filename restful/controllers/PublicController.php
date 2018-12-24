<?php
/**
 * Created by PhpStorm.
 * User: JawdatSobh
 * Date: 08/11/2018
 * Time: 14:42
 */

namespace restful\controllers;

use Yii;
use cnd\core\api\Controller;

class PublicController extends Controller
{
    /**
     * @SWG\Get(
     *     path="/ping",
     *     summary="Ping",
     *     @SWG\Response(
     *          response = 200,
     *          description = "Ping Response"
     *     )
     * )
     */
    public function actionPing(){
        return [];
    }
}