<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%product_detail}}".
 *
 * @property int $id
 * @property int $product_id
 * @property string $section
 * @property string $title
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Product $product
 * @property ProductDetailItem[] $productDetailItems
 */
class ProductDetail extends \cnd\core\components\ActiveRecord
{
    const SECTION_COMPANY = 1;
    const SECTION_PRE_ORDER = 2;
    const SECTION_TECHNICAL = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%product_detail}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['product_id'], 'integer'],
            [['section', 'title'], 'string', 'max' => 255],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'section' => 'Section',
            'title' => 'Title',
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
    public function getProductDetailItems()
    {
        return $this->hasMany(ProductDetailItem::className(), ['product_detail_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ProductDetailQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductDetailQuery(get_called_class());
    }

    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        $list = parent::toArray($fields, $expand, $recursive);
        $list['section'] = $this->section_label;
        $list['items'] = $this->productDetailItems;
        return $list;
    }
}
