<?php
use \yii\web\Request;
$baseUrl = str_replace('/restful/web', '/cnd-restful', (new Request)->getBaseUrl());

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'masterpak-restful',
    'name' => 'Indevco MasterPak Restful Api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'restful\controllers',
    'defaultRoute' => 'site/index',
    'bootstrap' => [
        'log',
        'cnd\admin\modules\api\Bootstrap',
        'cnd\notification\modules\api\Bootstrap',
        'cnd\notification\Bootstrap',
        'cnd\cms\modules\api\Bootstrap',
        'restful\components\Bootstrap',
    ],
    'modules' => [
        'system' => [
            'class' => 'cnd\core\modules\system\Module',
            'userType' => function(){
                //return [\common\models\User::TYPE_DOCTOR];
            },
        ],
        'api' => [
            'class' => 'cnd\admin\modules\api\Module',
            /*'registrationInit' => function($userType, $userId) {
                \common\models\User::setupProfileSaver($userId);
            }*/
        ],
        'notification' => [
            'class' => 'cnd\notification\modules\api\Module',
        ],
        'cms' => [
            'class' => 'cnd\cms\modules\api\Module',
        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-masterpak-restful', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'masterpakRestful',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'params' => $params,
];
