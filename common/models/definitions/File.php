<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 12/12/2018
 * Time: 3:42 PM
 */

namespace common\models\definitions;

use Swagger\Annotations as SWG;

/**
 * @SWG\Definition(required={"title"})
 *
 * @SWG\Property(property="id", type="integer")
 * @SWG\Property(property="title", type="string")
 * @SWG\Property(property="version", type="integer")
 * @SWG\Property(property="extension", type="string")
 * @SWG\Property(property="status", type="integer")
 * @SWG\Property(property="content_id", type="integer")
 * @SWG\Property(property="created_at", type="integer")
 * @SWG\Property(property="updated_at", type="integer")
 */
class File
{

}