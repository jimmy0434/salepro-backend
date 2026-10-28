<?php
/**
 * Created by PhpStorm.
 * User: JawdatSobh
 * Date: 07/11/2018
 * Time: 09:28
 */

namespace common\components;

use backend\components\BiMapSync;
use cnd\cms\components\Cms;
use cnd\core\components\Authentication;
use cnd\core\components\Core;
use cnd\core\components\Helper;
use cnd\core\components\Image;
use cnd\core\components\Setting;
use cnd\core\data\TimeZone;
use cnd\notification\components\Notification;
use cnd\notification\components\PushNotification;
use common\models\DataList;
use yii\db\Connection;
use yii\helpers\ArrayHelper;
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
 * @property UrlManager $urlManagerFrontend
 * @property UrlManager $urlManagerBackend
 * @property UrlManager $urlManagerApi
 * @property Keycloak $keycloak
 * @property Connection $bi
 * @property BiMapSync $biMapSync
 *
 */
class Application extends \yii\web\Application
{
    public function secretKey($id, $order)
    {
        return "CD" . $id . "?.*" . $order . "MP";
    }

    private static $_dataList = [];

    private function dataList($type, $parent = null)
    {
        $key = $type . '-' . ($parent ? $parent : '0');
        if (!isset(static::$_dataList[$key])) {
            $query = DataList::find();
            $query->where(['type' => $type, 'parent_id' => $parent]);
            $query->orderBy(['name' => SORT_ASC]);
            static::$_dataList[$key] = ArrayHelper::map($query->all(), 'name', 'name');
        }
        return static::$_dataList[$key];
    }

    public function countries()
    {
        return $this->dataList(DataList::TYPE_COUNTRY);
    }

    //static private $regionsList = null;
    public function regions()
    {
        return $this->dataList(DataList::TYPE_REGION);
    }
    public function tags()
    {
        return $this->dataList(DataList::TYPE_NEWS_TAG);
    }

    public function newstype()
    {
        return $this->dataList(DataList::TYPE_NEWS_TYPE);
    }
    public function newssteep()
    {
        return $this->dataList(DataList::TYPE_NEWS_MARKET_TREND);
    }
    public function newssector()
    {
        return $this->dataList(DataList::TYPE_NEWS_SECTOR);
    }
}

