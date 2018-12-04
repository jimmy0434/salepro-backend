<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 12/4/2018
 * Time: 2:33 PM
 */

namespace common\models;

use Yii;
use cnd\admin\models\activerecords\Log;

class LogBi extends Log
{
    public static function getDb()
    {
        return Yii::$app->bi;
    }

    public static function tableName() {
        return 'log';
    }
}