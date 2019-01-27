<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%brand}}".
 *
 * @property int $id
 * @property string $uid
 * @property int $portfolio_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Portfolio $portfolio
 * @property BrandBusinessUnit[] $brandBusinessUnits
 * @property ProductBrand[] $productBrands
 * @property SectorBrand[] $sectorBrands
 */
class Brand extends \cnd\core\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%brand}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(),[
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
    public function getPortfolio()
    {
        return $this->hasOne(Portfolio::className(), ['id' => 'portfolio_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrandBusinessUnits()
    {
        return $this->hasMany(BrandBusinessUnit::className(), ['brand_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductBrands()
    {
        return $this->hasMany(ProductBrand::className(), ['brand_id' => 'id']);
    }

    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'product_id'])->via('productBrands');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSectorBrands()
    {
        return $this->hasMany(SectorBrand::className(), ['brand_id' => 'id']);
    }

    public function getSectors()
    {
        return $this->hasMany(Sector::className(), ['id' => 'sector_id'])->via('sectorBrands');
    }

    /**
     * {@inheritdoc}
     * @return BrandQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BrandQuery(get_called_class());
    }

    public static function relateToPortfolio($portfolioId) {
        $model = static::find()->where(['portfolio_id'=>$portfolioId])->one();
        if(!$model){
            $model = new static();
            $model->uid = uniqid('brand-', true);
            $model->portfolio_id = $portfolioId;
            $model->save();
        }
    }
}
