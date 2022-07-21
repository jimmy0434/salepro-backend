<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mpk_product".
 *
 * @property int $id
 * @property string $uid
 * @property int $portfolio_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property MarketResearchProduct[] $marketResearchProducts
 * @property Portfolio $portfolio
 * @property ProductBrand[] $productBrands
 * @property ProductBusinessUnit[] $productBusinessUnits
 * @property ProductCertification[] $productCertifications
 * @property ProductDetail[] $productDetails
 * @property ProductIndustries[] $productIndustries
 * @property ProductSector[] $productSectors
 */
class Product extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mpk_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['portfolio_id'], 'integer'],
            [['uid'], 'string', 'max' => 255],
            [['uid'], 'unique'],
            [['portfolio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Portfolio::className(), 'targetAttribute' => ['portfolio_id' => 'id']],
        ]);


       
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
    public function getExhibitionItemProducts()
    {
        return $this->hasMany(ExhibitionItemProduct::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMarketResearches()
    {
        return $this->hasMany(MarketResearch::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductBusinessUnits()
    {
        return $this->hasMany(ProductBusinessUnit::className(), ['product_id' => 'id']);
    }

    public function getBusinessUnits()
    {
        return $this->hasMany(BusinessUnit::className(), ['id' => 'business_unit_id'])->via('productBusinessUnits');
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
    public function getProductBrands()
    {
        return $this->hasMany(ProductBrand::className(), ['product_id' => 'id']);
    }

    public function getBrands()
    {
        return $this->hasMany(Brand::className(), ['id' => 'brand_id'])->via('productBrands');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductSectors()
    {
        return $this->hasMany(ProductSector::className(), ['product_id' => 'id']);
    }

    public function getSectors()
    {
        return $this->hasMany(Sector::className(), ['id' => 'sector_id'])->via('productSectors');
    }

    public function getDetails()
    {
        return $this->hasMany(ProductDetail::className(), ['product_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductQuery(get_called_class());
    }

    public static function relateToPortfolio($portfolioId)
    {
        $model = static::find()->where(['portfolio_id' => $portfolioId])->one();
        if (!$model) {
            $model = new static();
            $model->uid = uniqid('product-', true);
            $model->portfolio_id = $portfolioId;
            $model->save();
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductCertifications()
    {
        return $this->hasMany(ProductCertification::className(), ['product_id' => 'id']);
    }

    public function getCertifications()
    {
        return $this->hasMany(Certification::className(), ['id' => 'certification_id'])->via('productCertifications');
    }
    
    public function getProductIndustries()
    {
        return $this->hasMany(ProductIndustries::className(), ['product_id' => 'id']);
    }


   

  

   
    public function getIndustries()
    {
        return $this->hasMany(Industries::className(), ['id' => 'industries_id'])->via('productIndustries');
    }
}


