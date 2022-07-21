<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mpk_industries".
 *
 * @property int $id
 * @property string $uid
 * @property int $portfolio_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Portfolio $portfolio
 * @property IndustriesBrand[] $industriesBrands
 * @property IndustriesBusinessUnit[] $industriesBusinessUnits
 * @property IndustriesSector[] $industriesSectors
 * @property ProductIndustries[] $productIndustries
 */
class Industries extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mpk_industries';
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
    public function getPortfolio()
    {
        return $this->hasOne(Portfolio::className(), ['id' => 'portfolio_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndustriesBrands()
    {
        return $this->hasMany(IndustriesBrand::className(), ['industries_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndustriesBusinessUnits()
    {
        return $this->hasMany(IndustriesBusinessUnit::className(), ['industries_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndustriesSectors()
    {
        return $this->hasMany(IndustriesSector::className(), ['industries_id' => 'id']);
    }
  
    public function getBusinessUnits()
    {
        return $this->hasMany(BusinessUnit::className(), ['id' => 'business_unit_id'])->via('industriesBusinessUnits');
    }
     public function getSectors()
    {
        return $this->hasMany(Sector::className(), ['id' => 'sector_id'])->via('industriesSectors');
    }
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'product_id'])->via('productIndustries');
    }

    public function getBrands()
    {
        return $this->hasMany(Brand::className(), ['id' => 'brand_id'])->via('industriesBrands');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductIndustries()
    {
        return $this->hasMany(ProductIndustries::className(), ['industries_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return IndustriesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new IndustriesQuery(get_called_class());
    }
    public static function relateToPortfolio($portfolioId)
    {
        $model = static::find()->where(['portfolio_id' => $portfolioId])->one();
        if (!$model) {
            $model = new static();
            $model->uid = uniqid('industries-', true);
            $model->portfolio_id = $portfolioId;
            $model->save();
        }
    }
}
