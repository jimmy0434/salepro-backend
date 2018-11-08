<?php
namespace common\models;

use cnd\admin\models\activerecords\Admin;
use cnd\admin\models\activerecords\User as BaseUser;
use common\components\Application;
use yii\web\Response;
use yii\web\UserEvent;
use Yii;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $type
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 *
 * @property Salesman $salesman
 * @property Salesman|Admin $profile
 */
class User extends BaseUser
{
    const TYPE_SALESMAN = 10;
    const STATUS_PENDING = 5;

    public function getProfile() {
        switch ($this->type) {
            case static::TYPE_SALESMAN:
                return $this->hasOne(Salesman::className(), ['id' => 'id']);
        }
        return parent::getProfile();
    }

    public function getSalesman() {
        return $this->hasOne(Salesman::className(), ['id' => 'id'])->from(['salesman'=> Salesman::tableName()]);
    }

    public static function beforeLogin($user){
        /**
         * @var $user UserEvent
         */
        if($user->identity->type == static::TYPE_SALESMAN){
            $macAddress = Yii::$app->request->post('macAddress');
            if(!$user->identity->salesman || !$macAddress || !$user->identity->salesman->mac_address || $macAddress != $user->identity->salesman->mac_address){
                $user->isValid = false;
                $user->sender->identity = null;
                Yii::$app->response->on(Response::EVENT_BEFORE_SEND, function($event){
                    Yii::$app->response->warning("Device not allowed");
                });
            }
        }
    }
}
