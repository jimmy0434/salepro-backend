<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%business_unit}}".
 *
 * @property int $id
 * @property string $uid
 * @property string $name
 * @property int $type
 * @property string $image
 * @property int $created_at
 * @property int $updated_at
 *
 * @property BrandBusinessUnit[] $brandBusinessUnits
 * @property CorporateBusinessUnit[] $corporateBusinessUnits
 * @property Exhibition[] $exhibitions
 * @property SectorBusinessUnit[] $sectorBusinessUnits
 */
class BusinessUnit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%business_unit}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'created_at', 'updated_at'], 'integer'],
            [['image'], 'string'],
            [['created_at', 'updated_at'], 'required'],
            [['uid', 'name'], 'string', 'max' => 255],
            [['uid'], 'unique'],
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
            'name' => 'Name',
            'type' => 'Type',
            'image' => 'Image',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrandBusinessUnits()
    {
        return $this->hasMany(BrandBusinessUnit::className(), ['business_unit_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCorporateBusinessUnits()
    {
        return $this->hasMany(CorporateBusinessUnit::className(), ['business_unit_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExhibitions()
    {
        return $this->hasMany(Exhibition::className(), ['business_unit_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSectorBusinessUnits()
    {
        return $this->hasMany(SectorBusinessUnit::className(), ['business_unit_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return BusinessUnitQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BusinessUnitQuery(get_called_class());
    }
}
