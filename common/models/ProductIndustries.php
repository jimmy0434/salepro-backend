<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mpk_product_industries".
 *
 * @property int $id
 * @property int $product_id
 * @property int $industries_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Product $product
 * @property Industries $industries
 */
class ProductIndustries extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mpk_product_industries';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'industries_id', 'created_at', 'updated_at'], 'integer'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
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
            'product_id' => 'Product ID',
            'industries_id' => 'Industries ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
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
     * @return ProductIndustriesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductIndustriesQuery(get_called_class());
    }
}
