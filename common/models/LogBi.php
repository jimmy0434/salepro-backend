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
use yii\helpers\Json;

class LogBi extends Log
{
    public $data = null;

    public static function getDb()
    {
        return Yii::$app->bi;
    }

    public static function tableName() {
        return 'log';
    }

    public function getChanges(){
        return $this->hasMany(LogChangeBi::className(),['log_id' => 'id']);
    }

    public function afterFind()
    {
        parent::afterFind();
        $list = [];
        $changes = $this->changes;
        if(!empty($changes) && is_array($changes)){
            foreach($changes as $change){
                $list[$change->name] = [
                    'oldValue' => $change->from,
                    'newValue' => $change->to,
                ];
            }
        }
        $this->data = Json::encode($list);
    }
}