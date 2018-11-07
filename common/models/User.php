<?php
namespace common\models;

use cnd\admin\models\activerecords\Admin;
use cnd\admin\models\activerecords\Setting;
use Yii;
use yii\helpers\Html;
use cnd\admin\models\activerecords\User as BaseUser;

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
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 *
 * @property Client $client
 * @property Client|Admin $profile
 */
class User extends BaseUser
{
    const TYPE_SALESMAN = 10;
    const STATUS_PENDING = 5;

    public function getProfile() {
        /*switch ($this->type) {
            case static::TYPE_SALESMAN:
                return $this->hasOne(Client::className(), ['id' => 'id']);
        }*/
        return parent::getProfile();
    }

    /*public function getSalesman() {
        return $this->hasOne(Client::className(), ['id' => 'id'])->from(['client'=> Client::tableName()]);
    }*/
}
