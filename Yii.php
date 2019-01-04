<?php
/**
 * Created by PhpStorm.
 * User: JawdatSobh
 * Date: 07/11/2018
 * Time: 09:29
 */

if (!@include_once(__DIR__ . '/vendor/yiisoft/yii2/BaseYii.php')) {
    require_once __DIR__ . '/vendor/yiisoft/yii2/BaseYii.php';
}


use yii\BaseYii;
use yii\helpers\Html;

/**
 * Created by PhpStorm.
 * User: JawdatSobh
 * Date: 02/07/2018
 * Time: 10:21
 */

class Yii extends BaseYii
{

    /* @var \yii\console\Application|\yii\web\Application|\common\components\Application  the application instance */
    public static $app;

    /**
     * Returns an HTML hyperlink that can be displayed on your Web page showing "Powered by Yii Framework" information.
     *
     * @return string an HTML hyperlink that can be displayed on your Web page showing "Powered by Codendot" information
     * @deprecated since 2.0.14, this method will be removed in 2.1.0.
     */
    public static function powered()
    {
        return static::t('app', 'Powered by {codendot}', [
            'codendot' => Html::a(static::t('app', 'Codendot'),'https://www.codendot.com/',['rel'=>'external','target'=>'_blank']),
        ]);
    }
}

spl_autoload_register(['Yii', 'autoload'], true, true);
if (!@include_once(__DIR__ . '/vendor/yiisoft/yii2/classes.php')) {
    require_once __DIR__ . '/vendor/yiisoft/yii2/classes.php';
}
Yii::$container = new \yii\di\Container();