<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%corporate_file}}".
 *
 * @property int $id
 * @property int $corporate_id
 * @property int $file_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Corporate $corporate
 * @property File $file
 */
class CorporateFile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%corporate_file}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['corporate_id', 'file_id'], 'integer'],
            [['corporate_id'], 'exist', 'skipOnError' => true, 'targetClass' => Corporate::className(), 'targetAttribute' => ['corporate_id' => 'id']],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['file_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'corporate_id' => 'Corporate ID',
            'file_id' => 'File ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCorporate()
    {
        return $this->hasOne(Corporate::className(), ['id' => 'corporate_id']);
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
     * @return CorporateFileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CorporateFileQuery(get_called_class());
    }
}
