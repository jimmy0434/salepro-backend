<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%sector}}".
 *
 * @property int $id
 * @property string $uid
 * @property int $portfolio_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property CorporateSector[] $corporateSectors
 * @property ProductSector[] $productSectors
 * @property Portfolio $portfolio
 * @property SectorBrand[] $sectorBrands
 * @property SectorBusinessUnit[] $sectorBusinessUnits
 */
class Sector extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sector}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['portfolio_id'], 'integer'],
            [['uid'], 'string', 'max' => 255],
            [['uid'], 'unique'],
            [['portfolio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Portfolio::className(), 'targetAttribute' => ['portfolio_id' => 'id']],
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
            'portfolio_id' => 'Portfolio ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCorporateSectors()
    {
        return $this->hasMany(CorporateSector::className(), ['sector_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductSectors()
    {
        return $this->hasMany(ProductSector::className(), ['sector_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortfolio()
    {
        return $this->hasOne(Portfolio::className(), ['id' => 'portfolio_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSectorBrands()
    {
        return $this->hasMany(SectorBrand::className(), ['sector_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSectorBusinessUnits()
    {
        return $this->hasMany(SectorBusinessUnit::className(), ['sector_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return SectorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SectorQuery(get_called_class());
    }
}
