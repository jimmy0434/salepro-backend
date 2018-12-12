<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 12/11/2018
 * Time: 5:29 PM
 */

namespace backend\components;

use Yii;
use yii\web\Response;

class OpenAPIRenderer extends \yii2mod\swagger\OpenAPIRenderer
{
    public function run(): Response
    {
       $this->enableCORS();
       Yii::$app->response->format = 'json';
       return $this->controller->asJson($this->getSwaggerDocumentation());
    }
}