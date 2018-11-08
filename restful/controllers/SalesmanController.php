<?php
/**
 * Created by PhpStorm.
 * User: JawdatSobh
 * Date: 08/11/2018
 * Time: 09:23
 */

namespace restful\controllers;


use cnd\core\api\Controller;

class SalesmanController extends Controller
{
    public function actionAuth(){
        return ['get'=>$_GET,'post'=>$_POST];
    }
}