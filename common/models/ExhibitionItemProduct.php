<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%exhibition_item_product}}".
 *
 * @property int $id
 * @property int $exhibition_id
 * @property int $exhibition_item_id
 * @property int $product_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Exhibition $exhibition
 * @property Product $product
 * @property ExhibitionItem $exhibitionItem
 */
class ExhibitionItemProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%exhibition_item_product}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['exhibition_id', 'exhibition_item_id', 'product_id'], 'integer'],
            [['exhibition_id'], 'exist', 'skipOnError' => true, 'targetClass' => Exhibition::className(), 'targetAttribute' => ['exhibition_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['exhibition_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => ExhibitionItem::className(), 'targetAttribute' => ['exhibition_item_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'exhibition_id' => 'Exhibition ID',
            'exhibition_item_id' => 'Exhibition Item ID',
            'product_id' => 'Product ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExhibition()
    {
        return $this->hasOne(Exhibition::className(), ['id' => 'exhibition_id']);
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
    public function getExhibitionItem()
    {
        return $this->hasOne(ExhibitionItem::className(), ['id' => 'exhibition_item_id']);
    }

    /**
     * {@inheritdoc}
     * @return ExhibitionItemProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ExhibitionItemProductQuery(get_called_class());
    }
}
