<?php

use common\models\User;
use yii\helpers\Html;
use yii\web\Request;

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'bootstrap' => [
        'cnd\core\Bootstrap',
        //'common\components\Bootstrap',
        [
            'class' => 'cnd\core\BootstrapLanguage',
            'supportedLanguages' => [
                'en' => ['English', 'ltr'],
            ],
        ],
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'image' => [
            'class' => 'cnd\core\components\Image',
            'baseUrl' => str_replace(['/backend/web', '/restful/web'], '/cnd-static', (new Request())->getBaseUrl())
        ],
        'authentication' => [
            'class' => 'cnd\core\components\Authentication',
        ],
        'setting' => [
            'class' => 'cnd\core\components\Setting',
            'definitions' => [
                'user' => [
                ],
                'page' => [
                ],
                'app' => [
                ],
            ],
        ],
        'helper' => [
            'class' => 'cnd\core\components\Helper',
        ],
        'timezone' => [
            'class' => 'cnd\core\data\TimeZone',
        ],
        'i18n' => array(
            'translations' => array(
                'app*' => array(
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                ),
            ),
        ),
        'core' => [
            'class' => 'cnd\core\components\Core',
            'emailsTemplates' => [
                'clientNewPassword' => [
                    'title' => 'User New Password',
                    'data' => ['name', 'username', 'email', 'password', 'type', 'status'],
                ],
                /*'forgotPassword' => [
                    'title' => 'Forgot Password',
                    'data' => ['link', 'name'],
                ],
                'activateAccount' => [
                    'title' => 'Activate Account',
                    'data' => ['name', 'link'],
                ],
                'accountActivated' => [
                    'title' => 'Account Activated',
                    'data' => ['profile', 'name'],
                ],
                'userResetPassword' => [
                    'title' => 'User Reset Password',
                    'data' => ['username', 'email', 'password'],
                ],*/
            ],
        ],
        'notification' => [
            'class' => 'cnd\notification\components\Notification',
            'messageTemplates' => [
                'default' => function ($name, $data) {
                    return '<div class="text-muted">' . $data['message'] . '</div>';
                },
                'file-update' => function ($name, $data) {
                    return Html::tag('div', Html::a($data['message'], [
                        '/file/index',
                        '_page' => 1,
                        '_pageSize' => 10,
                        '_filter' => [
                            'id' => [
                                'condition' => '=',
                                'value' => $data['id'],
                            ],
                        ],
                    ]), ['class' => 'text-muted', 'data' => ['id' => $data['id']]]);
                },
                'portfolio-update' => function ($name, $data) {
                    return Html::tag('div', Html::a($data['message'], [
                        '/portfolio/index',
                        't' => $data['target'],
                        '_page' => 1,
                        '_pageSize' => 10,
                        '_filter' => [
                            'id' => [
                                'condition' => '=',
                                'value' => $data['id'],
                            ],
                        ],
                    ]), ['class' => 'text-muted', 'data' => ['id' => $data['id']]]);
                },
                'portfolio-update-grant' => function ($name, $data) {
                    return Html::tag('div', Html::a($data['message'], [
                        '/portfolio/index',
                        't' => $data['target'],
                        '_page' => 1,
                        '_pageSize' => 10,
                        '_filter' => [
                            'id' => [
                                'condition' => '=',
                                'value' => $data['id'],
                            ],
                        ],
                    ]), ['class' => 'text-muted', 'data' => ['id' => $data['id']]]);
                },
            ],
            'template' => function ($content, $notification, $notificationUser) {
                ob_start();
                ?>
                <div class="notification-box notification-box-<?= strtolower($notificationUser->status_label) ?>">
                    <div class="notification-header">
                        <span class="date"><?= date('l, d F, Y @H:i', strtotime($notificationUser->date)) ?></span>
                    </div>
                    <div class="notification-body">
                        <?= $content ?>
                    </div>
                </div>
                <?php
                return ob_get_clean();
            },
        ],
        'pushNotification' => [
            'class' => 'cnd\notification\components\PushNotification',
            'androidKey' => 'AIzaSyDWK7LU1teqabSBGE6W1EW1hsay0tvfLQk',
            'iosCertification' => '@static/public/ssccprod.pem',
            'iosPassPhrase' => 'pass*123',
            'env' => 'prod',
            'data' => [
                'default' => function ($name, $data) {
                    return [
                        'message' => $data['message'],
                        'name' => $name,
                    ];
                },
            ],
        ],
        'keycloak' => [
            'class' => '\common\components\Keycloak',
        ],
        'userGroup' => [
            'class' => 'cnd\core\components\UserGroupProvider',
            'list' => [
                'salesman' => [
                    'title' => 'Salesman',
                    'callback' => function ($query) {
                        $query->andWhere(['user.type' => User::TYPE_SALESMAN, 'user.status' => User::STATUS_ACTIVE]);
                    }
                ],
            ],
        ],
    ],
];
