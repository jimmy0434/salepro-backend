<?php
/**
 * Created by PhpStorm.
 * User: JawdatSobh
 * Date: 07/11/2018
 * Time: 10:22
 */

namespace restful\components;

use Yii;
use yii\base\BootstrapInterface;
use \yii\web\Request;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app) {

        $baseUrl = str_replace('/restful/web', '/cnd-restful', (new Request)->getBaseUrl());
        Yii::$app->setComponents(
            [
                'request' => [
                    'class' => 'yii\web\Request',
                    'enableCookieValidation' => false,
                    'enableCsrfValidation' => false,
                    'parsers' => [
                        'application/json' => 'yii\web\JsonParser',
                    ],
                    'baseUrl' => $baseUrl,
                ],
                'response' => [
                    'class' => 'cnd\core\api\Response',
                    'charset' => 'UTF-8',
                    'on beforeSend' => function ($event) {
                        $response = $event->sender;
                        if (($exception = \Yii::$app->getErrorHandler()->exception) !== null) {
                            if ($exception instanceof \yii\web\HttpException) {
                                $response->statusCode = $exception->statusCode;
                            } else {
                                $response->statusCode = $exception->getCode();
                            }
                            $message = 'unknown message';
                            if ($exception instanceof \yii\base\Exception) {
                                $message = $exception->getName();
                            } else {
                                $message = Yii::t('yii', 'Error');
                            }
                            if ($exception instanceof \yii\base\UserException) {
                                $message = $exception->getMessage();
                            } else {
                                $message = Yii::t('yii', 'An internal server error occurred.');
                            }
                            $response->warning($message);
                        }
                    },
                ],
                'urlManager' => [
                    'class' => 'yii\web\UrlManager',
                    'baseUrl' => $baseUrl,
                    'enablePrettyUrl' => true,
                    'showScriptName' => false,
                    'enableStrictParsing' => false,
                    'rules' => \cnd\core\components\UrlRule::find(),
                ],
            ]
        );

    }
}