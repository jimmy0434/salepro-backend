<?php

use cnd\cms\components\ContentManager;
use cnd\cms\models\activerecords\Content;
use cnd\grid\DataLocator;
use common\models\File;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Request;
use common\models\Form;

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'bootstrap' => [
        'cnd\core\Bootstrap',
        'cnd\cms\CommonBootstrap',
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
            'afterContentSave' => function ($models, $isNewRecord) {
                $model = $models['original'];
                $en = $models['en'];
                if (\Yii::$app->request->get('type')) {
                    $type = \Yii::$app->request->get('type');
                    switch ($type) {
                        case "file":
                            $file = new File();
                            $file->content_id = $model->id;
                            $file->title = $en->title;
                            $file->status = File::STATUS_ACTIVE;
                            if ($file->save()) {
                                $model->section = 'file-' . $file->id;
                                $connection = \Yii::$app->db;
                                $connection->createCommand()->update(Content::tableName(), ['section' => $model->section], 'id = ' . $model->id)->execute();
                            }
                            break;
                        case "form":
                            $form = new Form();
                            $form->content_id = $model->id;
                            $form->name = $form->createSlug($en->title);
                            $form->title = $en->title;
                            $form->status = Form::STATUS_PENDING;
                            if ($form->save()) {
                                $model->section = 'form-' . $form->id;
                                $connection = \Yii::$app->db;
                                $connection->createCommand()->update(Content::tableName(), ['section' => $model->section], 'id = ' . $model->id)->execute();
                            }
                            break;
                    }
                }
                $section = $model->section;
                if ($section) {
                    $section = explode('-', $section);
                    if ($section[0] == 'file' && isset($section[1])) {
                        $id = $section[1];
                        $file = File::findOne($id);
                        if ($file !== null) {
                            $file->content_id = $model->id;
                            $file->title = $en->title;
                            $file->save(false);
                        }
                    } else if ($section[0] == 'form' && isset($section[1])) {
                        $id = $section[1];
                        $form = Form::findOne($id);
                        if ($form !== null) {
                            $form->content_id = $model->id;
                            $form->title = $en->title;
                            if (!$form->version) {
                                $form->name = $form->createSlug($en->title);
                            }
                            $form->save(false);
                        }
                    }
                }
            },
            'afterContentDelete' => function ($model) {
                /**
                 * @var $model Content
                 */
                $section = $model->section;
                if ($section) {
                    $section = explode('-', $section);
                    if ($section[0] == 'file' && isset($section[1])) {
                        $id = $section[1];
                        $file = File::findOne($id);
                        if ($file) {
                            $file->delete();
                        }
                    } else if ($section[0] == 'form' && isset($section[1])) {
                        $id = $section[1];
                        $form = Form::findOne($id);
                        if ($form) {
                            $form->delete();
                        }
                    }
                }
            },
            'headerAppend' => function ($dataLocator, $contentManager) {
                Url::remember();
                /**
                 * @var $dataLocator DataLocator
                 * @var $contentManager ContentManager
                 */
                ob_start();
                if (Yii::$app->permission->can('/cms/content/manage')) {
                    echo '&nbsp;&nbsp;' . Html::a('Add New File', Url::to(['manage', 'c' => $contentManager->category, 'type' => 'file']), ['class' => 'btn bg-olive']);
                }
                if (Yii::$app->permission->can('/cms/content/manage')) {
                    echo '&nbsp;&nbsp;' . Html::a('Add New Form', Url::to(['manage', 'c' => $contentManager->category, 'type' => 'form']), ['class' => 'btn bg-navy']);
                }
                return ob_get_clean();
            },
            'rowButtons' => function ($dataLocator, $contentManager) {
                /**
                 * @var $dataLocator DataLocator
                 * @var $contentManager ContentManager
                 */
                $fct = function ($model, $index) {
                    /**
                     * @var $model Content
                     */
                    $item = null;
                    $section = $model->section;
                    if ($section) {
                        ob_start();
                        list($type, $id) = explode('-', $section);
                        switch ($type) {
                            case "file":
                                if (!$item) {
                                    $item = File::findOne($id);
                                }
                                if ($item) {
                                    if ($index == 0 && \Yii::$app->permission->can('/file/manage-upload')) {
                                        echo Html::a('Upload', Url::to(['/file/manage-upload', 'id' => $item->id, 'c' => $model->id]), ['class' => 'btn bg-fuchsia']);
                                    }
                                    if ($index == 1 && $item->version && \Yii::$app->permission->can('/file/download')) {
                                        echo Html::a('Download', Url::to(['/file/download', 'id' => $item->id, 'c' => $model->id]), ['class' => 'btn bg-olive', 'target' => '_blank']);
                                    }
                                }
                                break;
                            case "form":
                                if (!$item) {
                                    $item = Form::findOne($id);
                                }
                                if ($item) {
                                    if ($index == 0 && \Yii::$app->permission->can('/form/manage-structure')) {
                                        echo Html::a('Builder', Url::to(['/form/manage-structure', 'id' => $item->id, 'c' => $model->id]), ['class' => 'btn bg-maroon']);
                                    }
                                    if ($index == 1 && isset($item->structure['fields']) && is_array($item->structure['fields']) && !empty($item->structure['fields']) && $item->version && \Yii::$app->permission->can('/form/publish-request') && $item->status != Form::STATUS_ACTIVE) {
                                        echo Html::a('Publish Request', Url::to(['/form/publish-request', 'id' => $item->id, 'c' => $model->id]), ['class' => 'btn bg-black']);
                                    }
                                }
                                break;
                        }
                        return ob_get_clean();
                    }
                    return null;
                };
                return [
                    function ($model) use ($fct) {
                        /**
                         * @var $model Content
                         */
                        return $fct($model, 1);
                    },
                    function ($model) use ($fct) {
                        /**
                         * @var $model Content
                         */
                        return $fct($model, 0);
                    },
                ];
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
                ],
            ],
        ],
        'notification' => [
            'class' => 'cnd\notification\components\Notification',
            'messageTemplates' => [
                'default' => function ($name, $data) {
                    return '<div class="text-muted">' . $data['message'] . '</div>';
                },
                'form-approval' => function ($name, $data) {
                    return Html::tag('div', Html::a($data['message'], ['/form-approval/view', 'id' => $data['id']]), ['class' => 'text-muted', 'data' => ['id' => $data['id']]]);
                },
                'form-approval-response' => function ($name, $data) {
                    return Html::tag('div', Html::a($data['message'], ['/form-approval/response', 'id' => $data['id']]), ['class' => 'text-muted', 'data' => ['id' => $data['id']]]);
                },
                'file-update' => function($name, $data){
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
                'form-update' => function($name, $data){
                    return Html::tag('div', Html::a($data['message'], [
                        '/form/index',
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
    ],
];
