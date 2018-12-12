<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 12/12/2018
 * Time: 3:43 PM
 */

namespace common\models\definitions;

use Swagger\Annotations as SWG;

/**
 * @SWG\Definition(required={"title"})
 *
 * @SWG\Property(property="id", type="integer")
 * @SWG\Property(property="name", type="string")
 * @SWG\Property(property="title", type="string")
 * @SWG\Property(property="version", type="integer")
 * @SWG\Property(property="status", type="integer")
 * @SWG\Property(property="content_id", type="integer")
 * @SWG\Property(property="structure", type="string")
 * @SWG\Property(property="created_at", type="integer")
 * @SWG\Property(property="updated_at", type="integer")
 */
class Form
{

}