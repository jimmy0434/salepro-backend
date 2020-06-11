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
 * @property Group $group
 */
class User extends BaseUser
{
    const TYPE_SALESMAN = 10;
    const STATUS_PENDING = 5;

    public function getProfile()
    {
        switch ($this->type) {
            case static::TYPE_SALESMAN:
                return $this->hasOne(Salesman::className(), ['id' => 'id']);
        }
        return parent::getProfile();
    }

    public function getSalesman()
    {
        return $this->hasOne(Salesman::className(), ['id' => 'id'])->from(['salesman' => Salesman::tableName()]);
    }

    public function getUser()
    {
        return $this->hasOne(Salesman::className(), ['id' => 'id'])->from(['salesman' => Salesman::tableName()]);
    }

    public static function beforeLogin($user)
    {
        /**
         * @var $user UserEvent
         */
        if ($user->identity->type == static::TYPE_SALESMAN && Yii::$app->requestedRoute == 'api/guest/login') {
            $macAddress = Yii::$app->request->post('macAddress');
            if ($macAddress && $user->identity->salesman && !$user->identity->salesman->mac_address) {
                $user->identity->salesman->mac_address = $macAddress;
                $user->identity->salesman->save(false);
            }
            if ($user->identity->salesman) {
                $user->identity->salesman->app_version = Yii::$app->request->post('appVersion');
                $user->identity->salesman->last_access_date = date("D M d, Y G:i");
                $user->identity->salesman->save(false);
            }
            if (!$user->identity->salesman || !$macAddress || !$user->identity->salesman->mac_address || $macAddress != $user->identity->salesman->mac_address) {
                $user->isValid = false;
                $user->sender->identity = null;
                Yii::$app->response->on(Response::EVENT_BEFORE_SEND, function ($event) {
                    Yii::$app->response->warning("Device not allowed");
                });
            }
        }
    }

    private $_sendNewPasswordEmail = false;

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($this->password && !$this->_sendNewPasswordEmail) {
            //Yii::$app->mailer->compose('@common/mail/account-password.php', ['user' => $this])->setSubject(Yii::t('app', 'New Password'))->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->params['adminName']])->setTo([$this->email])->send();
            $this->_sendNewPasswordEmail = true;
        }
    }

    public function getGroup()
    {
        return $this->hasOne(Group::className(), ['id' => 'group_id']);
    }
}
