<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 12/13/2018
 * Time: 12:00 PM
 */

namespace common\models\definitions;

use Swagger\Annotations as SWG;

/**
 * @SWG\Definition()
 *
 * @SWG\Property(property="id", type="integer")
 * @SWG\Property(property="templateName", type="string")
 * @SWG\Property(property="data", @SWG\Schema(type="object"))
 * @SWG\Property(property="status", type="integer")
 * @SWG\Property(property="statusLabel", type="string")
 * @SWG\Property(property="date", type="string")
 * @SWG\Property(property="created_at", type="integer")
 * @SWG\Property(property="updated_at", type="integer")
 */
class Notification
{

}

/**
 * @SWG\Definition()
 *
 * @SWG\Property(property="id", type="integer")
 * @SWG\Property(property="notification_id", type="integer")
 * @SWG\Property(property="user_id", type="integer")
 * @SWG\Property(property="status", type="integer")
 * @SWG\Property(property="date", type="string")
 * @SWG\Property(property="created_at", type="integer")
 * @SWG\Property(property="updated_at", type="integer")
 */
class NotificationUser
{

}

/**
 * @SWG\Definition()
 *
 * @SWG\Property(property="id", type="integer")
 * @SWG\Property(property="user_id", type="integer")
 * @SWG\Property(property="regid", type="string")
 * @SWG\Property(property="platform", type="string")
 * @SWG\Property(property="created_at", type="integer")
 * @SWG\Property(property="updated_at", type="integer")
 */
class NotificationDevice
{

}