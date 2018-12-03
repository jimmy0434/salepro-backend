<?php

use common\models\File;
use yii\helpers\Html;
use yii\web\Request;

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'bootstrap' => [
        'cnd\core\Bootstrap',
        'cnd\cms\CommonBootstrap',
        //'common\components\Bootstrap',
        [
            'class' => 'cnd\core\BootstrapLanguage',
            'supportedLanguages' => [
                'en'=>['English','ltr'],
            ],
        ],
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'image' => [
            'class' => 'cnd\core\components\Image',
            'baseUrl' => str_replace(['/backend/web','/restful/web'], '/cnd-static', (new Request())->getBaseUrl())
        ],
        'authentication' => [
            'class' => 'cnd\core\components\Authentication',
        ],
        'cms' => [
            'class' => 'cnd\cms\components\Cms',
            'templates' => [
                'none' => [
                    'title' => 'None',
                    'path' => false,
                ],
                'about' => [
                    'title' => 'About Us',
                    'path' => '@common/templates/about-us.php',
                ],
                'contact' => [
                    'title' => 'Contact Us',
                    'path' => '@common/templates/contact-us.php',
                ],
                'services' => [
                    'title' => 'Services',
                    'path' => '@common/templates/services.php',
                ],
                'content' => [
                    'title' => 'Content',
                    'path' => '@common/templates/content.php',
                ],
                'static-content' => null,
                'article' => null,
                'news' => null,
                'event' => null,
                'gallery' => null,
            ],
            'introsTemplate' => '@common/templates/intros.php',
            'introTemplate' => '@common/templates/intro.php',
            'introCol' => 6,
            'afterContentSave' => function($models,$isNewRecord){
                $model = $models['original'];
                $section = $model->section;
                if ($section) {
                    $section = explode('-', $section);
                    if ($section[0] == 'file' && isset($section[1])) {
                        $id = $section[1];
                        $file = File::findOne($id);
                        if ($file !== null) {
                            $file->content_id = $model->id;
                            $file->save(false);
                        }
                    }
                }
            },
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
                'forgotPassword' => [
                    'title' => 'Forgot Password',
                    'data' => ['link','name'],
                ],
                'activateAccount' => [
                    'title' => 'Activate Account',
                    'data' => ['name','link'],
                ],
                'accountActivated' => [
                    'title' => 'Account Activated',
                    'data' => ['profile','name'],
                ],
                'userResetPassword' => [
                    'title' => 'User Reset Password',
                    'data' => ['username','email','password'],
                ],
            ],
        ],
        'notification' => [
            'class' => 'cnd\notification\components\Notification',
            'messageTemplates' => [
                'default' => function($name, $data){
                    return '<div class="text-muted">'.$data['message'].'</div>';
                },
                'form-approval' => function ($name, $data) {
                    return Html::tag('div', Html::a($data['message'],['/form-approval/view','id'=>$data['id']]),['class' => 'text-muted', 'data' => ['id' => $data['id']]]);
                },
                'form-approval-response' => function ($name, $data) {
                    return Html::tag('div', Html::a($data['message'],['/form-approval/response','id'=>$data['id']]),['class' => 'text-muted', 'data' => ['id' => $data['id']]]);
                },
            ],
            'template' => function($content,$notification,$notificationUser){
                ob_start();
                ?>
                <div class="notification-box notification-box-<?= strtolower($notificationUser->status_label) ?>">
                    <div class="notification-header">
                        <span class="date"><?= date('l, d F, Y @H:i',strtotime($notificationUser->date)) ?></span>
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
                'default' => function($name, $data){
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
    ],
];
