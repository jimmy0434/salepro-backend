<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mpk_sector_outlook".
 *
 * @property int $id
 * @property string $uid
 * @property int $salesman_id
 * @property string $name
 * @property string $industry
 * @property string $country
 * @property string $outlook
 * @property string $source
 * @property string $growth_rate
 * @property resource $file
 * @property string $file_ext
 * @property int $created_at
 * @property int $updated_at
 * @property int $business_unit_id
 *
 * @property Salesman $salesman
 * @property BusinessUnit $businessUnit
 */
class SectorOutlook extends \common\components\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mpk_sector_outlook';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['salesman_id', 'created_at', 'updated_at', 'business_unit_id'], 'integer'],
            [['file'], 'string'],
            [['uid', 'name', 'industry', 'country', 'outlook', 'source', 'growth_rate', 'file_ext'], 'string', 'max' => 255],
            [['uid'], 'unique'],
            [['salesman_id'], 'exist', 'skipOnError' => true, 'targetClass' => Salesman::className(), 'targetAttribute' => ['salesman_id' => 'id']],
            [['business_unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => BusinessUnit::className(), 'targetAttribute' => ['business_unit_id' => 'id']],
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
            'salesman_id' => 'Salesman ID',
            'name' => 'Name',
            'industry' => 'Industry',
            'country' => 'Country',
            'outlook' => 'Outlook',
            'source' => 'Source',
            'growth_rate' => 'Growth Rate',
            'file' => 'File',
            'file_ext' => 'File Ext',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'business_unit_id' => 'Business Unit ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalesman()
    {
        return $this->hasOne(Salesman::className(), ['id' => 'salesman_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessUnit()
    {
        return $this->hasOne(BusinessUnit::className(), ['id' => 'business_unit_id']);
    }

    /**
     * {@inheritdoc}
     * @return SectorOutlookQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SectorOutlookQuery(get_called_class());
    }
  
  public function beforeSave($insert)
    {
        if ($this->isNewRecord || !$this->uid) {
            $this->uid = uniqid('Sector-outlook-', true);
        }

        // comment this before run migration for search index update
        if (!Yii::$app->user->isGuest && !$this->salesman_id && Yii::$app->user->identity->type == User::TYPE_SALESMAN) {
            $this->salesman_id = Yii::$app->user->identity->id;
        }

        

        return parent::beforeSave($insert);
    }
    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        $list = parent::toArray($fields, $expand, $recursive);
      
       

        $list['businessUnit'] = null;
        if ($this->businessUnit && $this->businessUnit->portfolio) {
            $list['businessUnit'] = $this->businessUnit->portfolio->uid;
        }

        return $list;
    }

}
