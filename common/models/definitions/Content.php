<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 12/12/2018
 * Time: 3:33 PM
 */

namespace common\models\definitions;

use Swagger\Annotations as SWG;

/**
 * @SWG\Definition()
 *
 * @SWG\Property(property="id", type="integer")
 * @SWG\Property(property="title", type="string")
 * @SWG\Property(property="excerpt", type="string")
 * @SWG\Property(property="text", type="string")
 * @SWG\Property(property="cover", type="string")
 * @SWG\Property(property="images", type="array", @SWG\Items(type="string"))
 * @SWG\Property(property="file", ref="#/definitions/File")
 * @SWG\Property(property="form", ref="#/definitions/Form")
 * @SWG\Property(property="status", type="integer")
 * @SWG\Property(property="categories", type="array", @SWG\Items(type="integer"))
 * @SWG\Property(property="category_id", type="integer")
 * @SWG\Property(property="created_at", type="integer")
 * @SWG\Property(property="updated_at", type="integer")
 */
class Content
{

}