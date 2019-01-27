<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%sector_brand}}".
 *
 * @property int $id
 * @property int $sector_id
 * @property int $brand_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Sector $sector
 * @property Brand $brand
 */
class SectorBrand extends \cnd\core\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sector_brand}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['sector_id', 'brand_id'], 'integer'],
            [['sector_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sector::className(), 'targetAttribute' => ['sector_id' => 'id']],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => Brand::className(), 'targetAttribute' => ['brand_id' => 'id']],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sector_id' => 'Sector ID',
            'brand_id' => 'Brand ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSector()
    {
        return $this->hasOne(Sector::className(), ['id' => 'sector_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
    }

    /**
     * {@inheritdoc}
     * @return SectorBrandQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SectorBrandQuery(get_called_class());
    }
}
