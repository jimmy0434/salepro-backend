<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 12/11/2018
 * Time: 5:19 PM
 */

namespace common\models\definitions;

use Swagger\Annotations as SWG;

/**
 * @SWG\Definition(required={"username", "email"})
 *
 * @SWG\Property(property="id", type="integer")
 * @SWG\Property(property="name", type="string")
 * @SWG\Property(property="status", type="integer")
 * @SWG\Property(property="type", type="integer")
 * @SWG\Property(property="accessToken", type="string")
 * @SWG\Property(property="fullName", type="string")
 * @SWG\Property(property="statusLabel", type="string")
 * @SWG\Property(property="typeLabel", type="string")
 * @SWG\Property(property="profile", ref="#/definitions/Profile")
 * @SWG\Property(property="created_at", type="integer")
 * @SWG\Property(property="updated_at", type="integer")
 */
class User
{

}