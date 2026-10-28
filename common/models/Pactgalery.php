<?php

namespace common\models;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use Yii;

/**
 * This is the model class for table "mpk_pactgalery".
 *
 * @property int $id
 * @property string $name
 * @property int $file_id
 * @property int $created_at
 * @property int $updated_at
 */
class Pactgalery extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mpk_pactgalery';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file_id', 'created_at', 'updated_at'], 'integer'],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['file_id' => 'id']],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'file_id' => 'File ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return PactgaleryQuery the active query used by this AR class.
     */
     /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(File::className(), ['id' => 'file_id']);
    }
    public static function find()
    {
        return new PactgaleryQuery(get_called_class());
    }
    
    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        $list = parent::toArray($fields, $expand, $recursive);
        unset($list['file_id']);
        $list['file'] = $this->file;
        
        return $list;
    }

    public function sendNotification()
    {
        $users = array_values(ArrayHelper::map(User::find()->where(['status' => User::STATUS_ACTIVE, 'type' => User::TYPE_SALESMAN])->all(), 'id', 'id'));
        Yii::$app->notification->send('pact-update', [
            'message' => 'pact-galery Update',
            'id' => $this->id,
           
        ], $users);
    }
}
