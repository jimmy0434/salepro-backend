<?php

namespace common\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "{{%base_log}}".
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
class AppUsage extends \common\components\ActiveRecord
{
    public $data = null;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%base_log}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['user_id'], 'integer'],
            [['message', 'data'], 'string'],
            [['date'], 'safe'],
            [['app'], 'string', 'max' => 50],
            [['level'], 'string', 'max' => 20],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ]);
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
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return AppUsageQuery the active query used by this AR class.
     */

    public static function find()
    {
        return new AppUsageQuery(get_called_class());
    }

}
