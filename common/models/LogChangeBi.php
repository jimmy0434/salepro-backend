<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 12/4/2018
 * Time: 4:16 PM
 */

namespace common\models;

use Yii;
use cnd\core\components\ActiveRecord;

class LogChangeBi extends ActiveRecord
{
    public static function getDb()
    {
        return Yii::$app->bi;
    }

    public static function tableName() {
        return 'log_change';
    }
}