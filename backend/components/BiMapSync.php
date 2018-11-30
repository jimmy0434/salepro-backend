<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11/30/2018
 * Time: 8:07 AM
 */

namespace backend\components;

use Yii;
use yii\base\Component;

class BiMapSync extends Component
{

    public $prefix;
    public $list = [];

    public function check($tableName, $model, $action){
        $tableName = str_replace($this->prefix."_","",$tableName);
        if(isset($this->list[$tableName])){
            $cls = $this->list[$tableName];
            $obj = Yii::createObject([
                "class" => $cls,
                "model" => $model,
                "action" => $action,
            ]);
            $obj->run();
            $obj->execute();
        }
    }
}