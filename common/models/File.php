<?php

namespace common\models;

use cnd\core\components\ActiveRecord;
use Yii;

/**
 * This is the model class for table "{{%file}}".
 *
 * @property int $id
 * @property string $sectors
 * @property string $corporates
 * @property string $brands
 * @property string $title
 * @property string $description
 * @property int $version
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property FilePartition[] $partitions
 */
class File extends ActiveRecord
{

    const STATUS_ACTIVE = 10;
    const STATUS_DRAFT = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%file}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sectors' => 'Sectors',
            'corporates' => 'Corporates',
            'brands' => 'Brands',
            'title' => 'Title',
            'description' => 'Description',
            'version' => 'Version',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartitions()
    {
        return $this->hasMany(FilePartition::className(), ['file_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return FileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FileQuery(get_called_class());
    }
}
