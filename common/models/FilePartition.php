<?php

namespace common\models;

use cnd\core\components\ActiveRecord;
use Yii;

/**
 * This is the model class for table "{{%file_partition}}".
 *
 * @property int $id
 * @property int $file_id
 * @property int $version
 * @property int $order
 * @property string extension
 * @property string $data
 * @property int $created_at
 * @property int $updated_at
 *
 * @property File $file
 */
class FilePartition extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%file_partition}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(),[
            [['data'], 'string'],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['file_id' => 'id']],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file_id' => 'File ID',
            'version' => 'Version',
            'order' => 'Order',
            'data' => 'Data',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(File::className(), ['id' => 'file_id']);
    }

    /**
     * {@inheritdoc}
     * @return FilePartitionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FilePartitionQuery(get_called_class());
    }
}
