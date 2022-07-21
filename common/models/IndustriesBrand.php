<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mpk_industries_brand".
 *
 * @property int $id
 * @property int $industries_id
 * @property int $brand_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Brand $brand
 * @property Industries $industries
 */
class IndustriesBrand extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mpk_industries_brand';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['industries_id', 'brand_id', 'created_at', 'updated_at'], 'integer'],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => Brand::className(), 'targetAttribute' => ['brand_id' => 'id']],
            [['industries_id'], 'exist', 'skipOnError' => true, 'targetClass' => Industries::className(), 'targetAttribute' => ['industries_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'industries_id' => 'Industries ID',
            'brand_id' => 'Brand ID',
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
    public function getIndustries()
    {
        return $this->hasOne(Industries::className(), ['id' => 'industries_id']);
    }

    /**
     * {@inheritdoc}
     * @return IndustriesBrandQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new IndustriesBrandQuery(get_called_class());
    }
}
