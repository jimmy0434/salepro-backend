<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use cnd\admin\models\activerecords\Log;

/**
 * This is the model class for table "mpk_directory".
 *
 * @property int $id
 * @property string $uid
 * @property string $name
 * @property string $title
 * @property string $phone
 * @property string $ext
 * @property string $cell
 * @property string $email
 * @property string $bu
 * @property int $created_at
 * @property int $updated_at
 */
class Directory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mpk_directory';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'integer'],
            [['uid', 'name', 'title', 'phone', 'ext', 'cell', 'email', 'bu'], 'string', 'max' => 255],
            [['uid'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'name' => 'Name',
            'title' => 'Title',
            'phone' => 'Phone',
            'ext' => 'Ext',
            'cell' => 'Cell',
            'email' => 'Email',
            'bu' => 'Bu',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return DirectoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DirectoryQuery(get_called_class());
    }
    public function beforeSave($insert)
    {
        if ($this->isNewRecord || !$this->uid) {
            $this->uid = uniqid('directory-', true);
        }

       
    
        

        return parent::beforeSave($insert);
    }
    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        $list = parent::toArray($fields, $expand, $recursive);
      
       

      

        return $list;
    }
    
  public function sendNotification()
  {
      $users = array_values(ArrayHelper::map(User::find()->where(['status' => User::STATUS_ACTIVE, 'type' => User::TYPE_SALESMAN])->all(), 'id', 'id'));
      Yii::$app->notification->send('directory-update', [
          'message' => 'Directory Update',
          'id' => $this->id,
      ], $users);
  }
}
