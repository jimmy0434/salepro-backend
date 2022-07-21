<?php

namespace common\models;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "mpk_sector".
 *
 * @property int $id
 * @property string $uid
 * @property int $portfolio_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property CorporateSector[] $corporateSectors
 * @property ExhibitionSector[] $exhibitionSectors
 * @property IndustriesSector[] $industriesSectors
 * @property MarketResearch[] $marketResearches
 * @property ProductSector[] $productSectors
 * @property Portfolio $portfolio
 * @property SectorBrand[] $sectorBrands
 * @property SectorBusinessUnit[] $sectorBusinessUnits
 */
class Sector extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mpk_sector';
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
    public function getExhibitionSectors()
    {
        return $this->hasMany(ExhibitionSector::className(), ['sector_id' => 'id']);
    }
    public function getBrands()
    {
        return $this->hasMany(Brand::className(), ['id' => 'brand_id'])->via('sectorBrands');
    }
   
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'product_id'])->via('productSectors');
    }
    public function getIndustries()
    {
        return $this->hasMany(Industries::className(), ['id' => 'industries_id'])->via('industriesSectors');
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndustriesSectors()
    {
        return $this->hasMany(IndustriesSector::className(), ['sector_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMarketResearches()
    {
        return $this->hasMany(MarketResearch::className(), ['sector_id' => 'id']);
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
    public function getBusinessUnits()
    {
        return $this->hasMany(BusinessUnit::className(), ['id' => 'business_unit_id'])->via('sectorBusinessUnits');
    }

    /**
     * {@inheritdoc}
     * @return SectorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SectorQuery(get_called_class());
    }

    public static function listData()
    {
        return ArrayHelper::map(static::find()->from(['sector' => static::tableName()])->joinWith([
            'portfolio' => function ($query) {
                $query->from(['portfolio' => Portfolio::tableName()]);
            }
        ])->orderBy(['portfolio.name' => SORT_ASC])->all(), 'portfolio.name', function ($model) {
            if ($model->portfolio) {
                return $model->portfolio->name;
            }
            return null;
        });
    }


    public static function relateToPortfolio($portfolioId)
    {
        $model = static::find()->where(['portfolio_id' => $portfolioId])->one();
        if (!$model) {
            $model = new static();
            $model->uid = uniqid('sector-', true);
            $model->portfolio_id = $portfolioId;
            $model->save();
        }
    }
}
