<?php
/**
 * Created by PhpStorm.
 * User: JawdatSobh
 * Date: 08/11/2018
 * Time: 14:42
 */

namespace restful\controllers;

use cnd\core\api\SController;
use cnd\admin\models\activerecords\Log;
use Yii;
use yii\helpers\Inflector;

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
    public function actionPing()
    {
    
        return[''];
    }

    public function actionSendTestEmail()
    {
        $result = Yii::$app->mailer->compose()
            ->setTo('sed.trainee@indevcogroup.com')
            ->setFrom('sed.trainee@indevcogroup.com')
            ->setSubject('Test Email')
            ->setTextBody('This is a test email.')
            ->send();

        if ($result) {
            echo 'Email sent successfully.';
        } else {
            echo 'Failed to send email.';
        }
    }
}
