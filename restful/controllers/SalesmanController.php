<?php
/**
 * Created by PhpStorm.
 * User: JawdatSobh
 * Date: 08/11/2018
 * Time: 09:23
 */

namespace restful\controllers;

use common\models\User;
use Yii;
use cnd\core\api\SController;

class SalesmanController extends SController
{
    /**
     * @SWG\Put(
     *     path="/change-password",
     *     tags={"User"},
     *     summary="Change user password",
     *     @SWG\Response(
     *         response = 200,
     *         description = "User Password Changed"
     *     ),
     *     security = {{"Bearer": {}}},
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer TOKEN", description="Authorization" ),
     *
     *     @SWG\Parameter(name="password", required=true, in="body", @SWG\Schema(type="string"), description="The new password")
     * )
     */
    public function actionChangePassword(){
        /* @var $user User */
        $password = Yii::$app->request->post('password');
        $user = Yii::$app->user->identity;
        $user->setPassword($password);
        $user->save(false);
        return ['saved'=>true];
    }
}
