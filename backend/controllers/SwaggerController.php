<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 12/11/2018
 * Time: 5:17 PM
 */

namespace backend\controllers;

use Yii;
use cnd\core\components\SController;
use yii\helpers\Url;
use Swagger\Annotations as SWG;

define("BASE_URL", str_replace(['cnd-admin', 'http://', 'https://'], ['api', '', ''], Url::base(true)));

/**
 * @SWG\Swagger(
 *     schemes={"http","https"},
 *     host=BASE_URL,
 *     basePath="/",
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="Indevco - MasterPak",
 *         description="Api for implement desktop app for indevco salesman",
 *         termsOfService="",
 *         @SWG\Contact(
 *             email="jawdat@codendot.com"
 *         )
 *     ),
 *     @SWG\SecurityScheme(
 *         securityDefinition="Bearer",
 *         type="apiKey",
 *         name="Authorization",
 *         in="header"
 *     )
 * )
 */
class SwaggerController extends SController
{
    public function actions()
    {
        return [
            'docs' => [
                'class' => 'yii2mod\swagger\SwaggerUIRenderer',
                'restUrl' => Url::to(['swagger/json-schema'], true),
            ],
            'json-schema' => [
                'class' => 'backend\components\OpenAPIRenderer',
                // Тhe list of directories that contains the swagger annotations.
                'scanDir' => [
                    Yii::getAlias('@backend/controllers/SwaggerController.php'),
                    Yii::getAlias('@restful/controllers'),
                    Yii::getAlias('@common/models/definitions'),
                ],
            ],
        ];
    }
}