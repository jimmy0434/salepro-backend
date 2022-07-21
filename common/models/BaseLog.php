<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mpk_base_log".
 *
 * @property int $id
 * @property string $app
 * @property int $user_id
 * @property string $message
 * @property string $data
 * @property string $date
 * @property string $level
 * @property int $created_at
 * @property int $updated_at
 *
 * @property BaseUser $user
 */
class BaseLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mpk_base_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['message', 'data'], 'string'],
            [['date'], 'safe'],
            [['created_at', 'updated_at'], 'required'],
            [['app'], 'string', 'max' => 50],
            [['level'], 'string', 'max' => 20],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => BaseUser::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'app' => 'App',
            'user_id' => 'User ID',
            'message' => 'Message',
            'data' => 'Data',
            'date' => 'Date',
            'level' => 'Level',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(BaseUser::className(), ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return MplLogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MplLogQuery(get_called_class());
    }
}
