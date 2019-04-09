<?php

namespace common\models;

use cnd\core\components\ActiveRecord;
use cnd\core\interfaces\UserProfile;
use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "{{%salesman}}".
 *
 * @property int $id
 * @property string $name
 * @property string $image
 * @property string $mac_address
 * @property string $job_title
 * @property string $first_name
 * @property string $last_name
 * @property string $dob
 * @property string $gender
 * @property string $city
 * @property string $address
 * @property string $phone
 * @property int $created_at
 * @property int $updated_at
 * @property string $userName
 * @property string $userType
 * @property string $userImage
 * @property string $userDisplay
 *
 * @property User $user
 */
class Salesman extends ActiveRecord implements UserProfile
{
    public $imageFactory;

    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%salesman}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['first_name','last_name'], 'required'],
            [['first_name','last_name','phone','dob','city', 'mac_address'], 'string', 'max' => 255],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id' => 'id']],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'image' => 'Image',
            'mac_address' => 'Mac Address',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return SalesmanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SalesmanQuery(get_called_class());
    }

    public function beforeSave($insert)
    {
        if (is_array($this->image)) {
            $this->image = Json::encode($this->image);
        }
        $this->name = $this->first_name.' '.$this->last_name;
        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        parent::afterFind();
        if (is_string($this->image) && Yii::$app->helper->isJson($this->image)) {
            $this->imageFactory = Yii::createObject([
                'class' => 'cnd\filemanager\components\FileOutput',
                'data' => $this->image,
            ]);
        } else {
            $this->imageFactory = Yii::createObject([
                'class' => 'cnd\filemanager\components\FileOutput',
                'data' => Yii::$app->image->defaultUser,
            ]);
        }
        if(!$this->first_name){
            $this->first_name = $this->name;
        }
    }

    public function getUserName()
    {
        return $this->name;
    }

    public function getUserType()
    {
        return $this->user->type_label;
    }

    public function getUserImage()
    {
        return ($this->imageFactory !== null) ? $this->imageFactory->url : '';
    }

    public function getUserDisplay()
    {
        return $this->userName;
    }

    public function setUserImage($data)
    {
        $this->image = $data;
        $this->imageFactory = Yii::createObject([
            'class' => 'cnd\filemanager\components\FileOutput',
            'data' => $this->image,
        ]);
    }

    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        $data = parent::toArray($fields, $expand, $recursive);
        $data['image'] = $this->imageFactory !== null ? $this->imageFactory->url : null;
        unset($data['mac_address']);
        return $data;
    }

    public static function setupProfileSaver($userId){
        $model = $userId != null?static::findOne($userId):new static();
        \cnd\core\components\Registration::registerModel('salesman',$model,['Salesman' => Yii::$app->request->post('salesman')]);
        \cnd\core\components\Registration::beforeSave('salesman',function($name,&$model,&$models){
            /*$model->id = $models['user']->id;
            if($model->isNewRecord){
                $models['user']->status = User::STATUS_PENDING;
                $models['user']->generatePasswordResetToken();
                Yii::$app->setting->user($model->id, true)->language = Yii::$app->request->get('_language');
                Yii::$app->controller->trace('language : '.Yii::$app->request->get('_language').' of user = '.$model->id);
                Yii::$app->language = Yii::$app->request->get('_language');
                Yii::$app->mailer->compose('@cnd/dtt/mail/account-confirmation',[
                    'token' => $models['user']->password_reset_token,
                    'name' => $model->firstname.' '.$model->lastname,
                    'userId' => $model->id
                ])
                    ->setFrom([Yii::$app->params['adminEmail']=>Yii::$app->params['adminName']])
                    ->setTo($models['user']->email)
                    ->setSubject(Yii::t('app','Registration Validation'))
                    ->send();
            }
            $models['user']->name = $model->userName;
            $models['user']->save();*/
        });
    }

    public function getParentReferral(){
        if($this->parent_referral_code){
            return $this->hasOne(Client::className(),['referral_code'=>'parent_referral_code']);
        }
        return null;

    }
}
