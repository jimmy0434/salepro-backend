<?php
use \yii\web\Request;
$baseUrl = str_replace('/backend/web', '/cnd-admin', (new Request)->getBaseUrl());

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'masterpak-backend',
    'name' => 'Indevco MasterPak Administration',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'defaultRoute' => 'admin/default/index',
    'bootstrap' => [
        'log',
        'cnd\admin\Bootstrap',
        'cnd\cms\modules\admin\Bootstrap',
        'cnd\notification\Bootstrap',
        'backend\components\Bootstrap',
    ],
    'modules' => [
        'system' => [
            'class' => 'cnd\core\modules\system\Module',
            'phoneAuthentication' => false,
            'emailAuthentication' => false,
        ],
        'admin' => [
            'class' => 'cnd\admin\Module',
            'name' => ['MASTER','Pak'],
            'shortName' => ['M','PK'],
            /*'autoLoginDefinition' => function($type){
                return !in_array($type,[\cnd\admin\models\activerecords\User::TYPE_ROOT,\cnd\admin\models\activerecords\User::TYPE_ADMIN]);
            },*/
        ],
        'filemanager' => [
            'class' => 'cnd\filemanager\Module',
            'mediaPath' => dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR.'static'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'media',
            'webroot' => '@static',
            'baseUrl' => str_replace('/backend/web', '/cnd-static', (new Request)->getBaseUrl()),
        ],
        'notification' => [
            'class' => 'cnd\notification\Module',
        ],
        'cms' => [
            'class' => 'cnd\cms\modules\admin\Module',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'baseUrl' => $baseUrl,
            'enableCsrfValidation' => !(YII_ENV_DEV || YII_ENV_TEST),
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'baseUrl' => $baseUrl,
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-masterpak-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'masterpak-backend',
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
        'errorHandler' => [
            'errorAction' => 'admin/default/error',
        ],
        'dashboard' => [
            'class' => 'cnd\core\admin\DashboardManager',
        ],
        'statistic' => [
            'class' => 'cnd\statistic\Statistic',
        ],
        'permission' => [
            'class' => 'cnd\core\components\Permission',
        ],
        'guide' => [
            'class' => 'cnd\core\components\GuideDoc',
        ],
    ],
    'params' => $params,
];
