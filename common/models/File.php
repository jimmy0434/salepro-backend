<?php

namespace common\models;

use cnd\cms\models\activerecords\Category;
use cnd\core\components\ActiveRecord;
use Yii;
use yii\helpers\ArrayHelper;

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
 * @property string extension
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property string $status_label
 * @property array $status_list
 * @property array $status_values
 *
 * @property FilePartition[] $partitions
 * @property int $versionsCount
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
        return array_merge(parent::rules(),[
            [['description'], 'string'],
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
     * @return int
     */
    public function getVersionsCount(){
        return $this->getPartitions()->groupBy('version')->count();
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
        if (is_array($this->sectors)) {
            $this->sectors = implode(',', $this->sectors);
        }
        if (is_array($this->corporates)) {
            $this->corporates = implode(',', $this->corporates);
        }
        if (is_array($this->brands)) {
            $this->brands = implode(',', $this->brands);
        }
        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        $this->sectors = explode(',', $this->sectors);
        $this->corporates = explode(',', $this->corporates);
        $this->brands = explode(',', $this->brands);
        parent::afterFind();
    }

    public function categories($name, $before = ' ', $after = ' ', $between = ''){
        if($this->hasProperty($name) && $this->$name) {
            $list = Yii::$app->cms->getCategory()->language(Yii::$app->language)->condition(['original_id'=>null,'id'=>$this->$name])->all();
            $list = ArrayHelper::map($list,'id','name');
            return $before.implode($after.$between.$before,$list).$after;
        }
    }
}
