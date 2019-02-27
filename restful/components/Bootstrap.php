<?php
/**
 * Created by PhpStorm.
 * User: JawdatSobh
 * Date: 07/11/2018
 * Time: 10:22
 */

namespace restful\components;

use cnd\core\api\Response;
use common\components\Application;
use Yii;
use yii\base\BootstrapInterface;
use cnd\core\components\UrlRule;
use yii\base\Event;
use yii\web\Request;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        /**
         * @var $app Application
         */

        $baseUrl = str_replace('/restful/web', '/api', (new Request)->getBaseUrl());

        UrlRule::register('get', '/ping', '/public/ping');
        UrlRule::register('get', '/swagger/docs', '/swagger/docs');
        UrlRule::register('get', '/portfolios', '/portfolio/list');
        UrlRule::register('get', '/portfolios/<uid:.+>', '/portfolio/one');
        UrlRule::register('get', '/sectors/<uid:.+>/products', '/portfolio/sectors-products');
        UrlRule::register('get', '/sectors/<sectorUid:.+>/market-research', '/market-research/list');
        UrlRule::register('get', '/brands/<uid:.+>/products', '/portfolio/brands-products');
        UrlRule::register('get', '/business-unit/<uid:.+>/products', '/portfolio/business-unit-products');
        UrlRule::register('get', '/products/bundling-packing', '/portfolio/bundling-packing');
        UrlRule::register('get', '/products/<uid:.+>/business-units', '/portfolio/product-business-units');
        UrlRule::register('get', '/search', '/search/find');
        UrlRule::register('get', '/files/<id:\d+>/download/<version:\d+>/<order:\d+>', '/file/download');
        UrlRule::register('get', '/forms/<id:\d+>', '/form/one');
        UrlRule::register('get', '/forms/<id:\d+>/crud', '/form/crud');
        UrlRule::register('post,put', '/forms/<id:\d+>', '/form/save');
        UrlRule::register('get', '/market-research', '/market-research/list');
        UrlRule::register('get', '/exhibitions', '/exhibition/list');
        UrlRule::register('get', '/sustainability', '/sustainability/list');
        UrlRule::register('get', '/statistic-numbers', '/data/statistic-numbers');
        UrlRule::register('get', '/data-list', '/data/data-list');
        UrlRule::register('get', '/marketing-directory', '/data/marketing-directory');
        UrlRule::register('get', '/competitions', '/competitor/list');
        UrlRule::register('post', '/competitions', '/competitor/manage');
        UrlRule::register('put', '/competitions/<uid:.+>', '/competitor/manage');
        UrlRule::register('get', '/competitions/<uid:.+>/logo', '/competitor/logo');
        UrlRule::register('get', '/competitions/<uid:.+>/file', '/competitor/file');
        UrlRule::register('get', '/competitions/<uid:.+>', '/competitor/profile');
        UrlRule::register('get', '/logistics', '/logistic/list');

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
                        /**
                         * @var $event Event
                         * @var $response Response
                         */
                        $response = $event->sender;
                        $response->data = $this->filterResponseData($response->data);
                        //echo '<pre>'.print_r($response->data, true).'</pre>'; die();
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

        $app->user->on(\yii\web\User::EVENT_BEFORE_LOGIN, ['common\models\User', 'beforeLogin']);

    }

    public function filterResponseData($data)
    {
        if (isset($data['articles']) && !empty($data['articles']) && is_array($data['articles'])) {
            foreach ($data['articles'] as &$article) {
                if (array_key_exists('privilege', $article)) {
                    unset($article['privilege']);
                }
                if (array_key_exists('original_id', $article)) {
                    unset($article['original_id']);
                }
                if (array_key_exists('language', $article)) {
                    unset($article['language']);
                }
                if (array_key_exists('config', $article)) {
                    unset($article['config']);
                }
                if (array_key_exists('setting', $article)) {
                    unset($article['setting']);
                }
                if (array_key_exists('section', $article) && $article['section']) {
                    list($targetName, $targetId) = explode('-', $article['section']);
                    if ($targetName) {
                        $article['section'] = $targetName;
                    }
                }
                if (array_key_exists('gallery', $article)) {
                    unset($article['gallery']);
                }
                if (array_key_exists('owner', $article)) {
                    unset($article['owner']);
                }
                if (array_key_exists('cover', $article)) {
                    $article['cover'] .= '?t=' . $article['updated_at'];
                }
            }
        }
        if (isset($data['categories']) && !empty($data['categories']) && is_array($data['categories'])) {
            foreach ($data['categories'] as &$category) {
                if (is_object($category)) {
                    $category = $category->toArray();
                }
                if (array_key_exists('original_id', $category)) {
                    unset($category['original_id']);
                }
                if (array_key_exists('parent_id', $category)) {
                    unset($category['parent_id']);
                }
                if (array_key_exists('language', $category)) {
                    unset($category['language']);
                }
                if (array_key_exists('extra', $category)) {
                    unset($category['extra']);
                }
                if (array_key_exists('path', $category)) {
                    unset($category['path']);
                }
                if (array_key_exists('config', $category)) {
                    unset($category['config']);
                }
                if (array_key_exists('setting', $category)) {
                    unset($category['setting']);
                }
            }
        }
        if (isset($data['user'])) {
            if (is_object($data['user'])) {
                $data['user'] = $data['user']->toArray();
            }
            $user = &$data['user'];
            if (array_key_exists('username', $data['user'])) {
                unset($data['user']['username']);
            }
            if (array_key_exists('password_reset_token', $user)) {
                unset($user['password_reset_token']);
            }
            if (array_key_exists('email', $data['user'])) {
                unset($data['user']['email']);
            }
            if (array_key_exists('role_id', $data['user'])) {
                unset($data['user']['role_id']);
            }
            if (array_key_exists('register', $data['user'])) {
                unset($data['user']['register']);
            }
            if (array_key_exists('socialid', $data['user'])) {
                unset($data['user']['socialid']);
            }
            if (array_key_exists('phone', $data['user'])) {
                unset($data['user']['phone']);
            }
            if (array_key_exists('firebase_id', $data['user'])) {
                unset($data['user']['firebase_id']);
            }
            if (array_key_exists('social_data', $data['user'])) {
                unset($data['user']['social_data']);
            }
        }
        return $data;
    }
}
