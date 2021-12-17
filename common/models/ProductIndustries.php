<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_industries".
 *
 * @property int $id
 * @property int $product_id
 * @property int $industries_id
 */
class ProductIndustries extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_industries';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'industries_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'industries_id' => 'Industries ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndustries()
    {
        return $this->hasOne(Industries::className(), ['id' => 'industries_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * {@inheritdoc}
     * @return ProductIndustriesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductIndustriesQuery(get_called_class());
    }
}
