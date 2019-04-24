<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%brand_business_unit}}".
 *
 * @property int $id
 * @property int $brand_id
 * @property int $business_unit_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Brand $brand
 * @property BusinessUnit $businessUnit
 */
class BrandBusinessUnit extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%brand_business_unit}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['brand_id', 'business_unit_id'], 'integer'],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => Brand::className(), 'targetAttribute' => ['brand_id' => 'id']],
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
            'brand_id' => 'Brand ID',
            'business_unit_id' => 'Business Unit ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
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
     * @return BrandBusinessUnitQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BrandBusinessUnitQuery(get_called_class());
    }
}
