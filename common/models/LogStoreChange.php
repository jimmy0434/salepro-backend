<?php

namespace common\models;

use cnd\core\components\ActiveRecord;
use Yii;

/**
 * This is the model class for table "{{%log_store_change}}".
 *
 * @property int $id
 * @property int $log_store_id
 * @property string $name
 * @property string $from
 * @property string $to
 * @property int $created_at
 * @property int $updated_at
 *
 * @property LogStore $logStore
 */
class LogStoreChange extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%log_store_change}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['log_store_id'], 'integer'],
            [['from', 'to'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['log_store_id'], 'exist', 'skipOnError' => true, 'targetClass' => LogStore::className(), 'targetAttribute' => ['log_store_id' => 'id']],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'log_store_id' => 'Log Store ID',
            'name' => 'Name',
            'from' => 'From',
            'to' => 'To',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogStore()
    {
        return $this->hasOne(LogStore::className(), ['id' => 'log_store_id']);
    }

    /**
     * {@inheritdoc}
     * @return LogStoreChangeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LogStoreChangeQuery(get_called_class());
    }
}
