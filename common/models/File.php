<?php

namespace common\models;

use cnd\cms\models\activerecords\Category;
use cnd\cms\models\activerecords\Content;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%file}}".
 *
 * @property int $id
 * @property string $title
 * @property int $version
 * @property string extension
 * @property int $status
 * @property int $content_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property string $status_label
 * @property array $status_list
 * @property array $status_values
 *
 * @property FilePartition[] $partitions
 * @property int $partitionsCount
 * @property int $versionsCount
 * @property Content $content
 */
class File extends \common\components\ActiveRecord
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
        return array_merge(parent::rules(),[
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content_id' => 'Content',
            'version' => 'Version',
            'name' =>'name',
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
        return $this->hasMany(FilePartition::className(), ['file_id' => 'id'])->from(['filePartition'=>FilePartition::tableName()])->where(['filePartition.version'=>$this->version]);
    }

    public function getPartitionsCount()
    {
        return $this->getPartitions()->count();
    }

    /**
     * @return int
     */
    public function getVersionsCount(){
        return $this->getPartitions()->groupBy('version')->count();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContent()
    {
        return $this->hasMany(Content::className(), ['id' => 'content_id']);
    }

    /**
     * {@inheritdoc}
     * @return FileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FileQuery(get_called_class());
    }

    public function beforeSave($insert)
    {
        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        parent::afterFind();
    }

    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        $data = parent::toArray($fields,$expand,$recursive);
        $data['partitions'] = intval($this->partitionsCount);
        return $data;
    }
}
