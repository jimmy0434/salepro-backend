<?php
/**
 * Created by PhpStorm.
 * User: JawdatSobh
 * Date: 07/11/2018
 * Time: 09:28
 */

namespace common\components;

use cnd\cms\components\Cms;
use cnd\core\components\Authentication;
use cnd\core\components\Core;
use cnd\core\components\Helper;
use cnd\core\components\Image;
use cnd\core\components\Setting;
use cnd\core\data\TimeZone;
use cnd\notification\components\Notification;
use cnd\notification\components\PushNotification;
use yii\web\UrlManager;


/**
 * Class Application
 *
 * @property Helper $helper
 * @property Core $core
 * @property Authentication $authentication
 * @property Setting $setting
 * @property Notification $notification
 * @property PushNotification $pushNotification
 * @property Cms $cms
 * @property Image $image
 * @property TimeZone $timezone
 * @property string $currency
 * @property UrlManager  $urlManagerFrontend
 * @property UrlManager  $urlManagerBackend
 * @property UrlManager  $urlManagerApi
 * @property Keycloak $keycloak
 *
 */
class Application extends \yii\web\Application
{

}