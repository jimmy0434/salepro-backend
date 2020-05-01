<?php
namespace cnd\admin\models\activerecords;

use Yii;
use cnd\core\components\ActiveRecord;
use yii\helpers\Json;

/**
 * Description of Log
 *
 * @author Jawdat Sobh <jawdat@codendot.com> <jawdat.sobh@gmail.com>
 */
class Log extends ActiveRecord{
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%base_log}}';
    }

    public function getUser(){
        return $this->hasOne(User::className(),['id'=>'user_id']);
    }

    protected static function add($level,$message,$data = []){
        $l = new static();
        $l->user_id = Yii::$app->user->isGuest?null:Yii::$app->user->identity->id;
        $l->app = Yii::$app->name;
        $l->message = $message;
        $l->data = Json::encode($data);
        $l->date = date('Y-m-d H:i:s');
        $l->level = $level;
        $l->save();
    }

    public static function db($message,$data = []){
        static::add('Database',$message,$data);
    }

    public static function request($message){
        static::add('Request',$message,[]);
    }

    public static function trace($message,$data = []){
        if(Yii::$app->name=='SalePro App' && $message=='User Login')
            static::add('App',$message,$data);
        else
            static::add('Trace',$message,$data);
    }

    public static function appLog($message,$data = []){
        static::add('App',$message,$data);
    }
    /*
    public static function trace($message){
        static::add('Trace',$message);
    }
    */

    public function dates(){
        return ['date'];
    }
}
