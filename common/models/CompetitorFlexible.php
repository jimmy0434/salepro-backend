<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%competitor_flexible}}".
 *
 * @property int $id
 * @property int $competitor_id
 * @property string $product_type
 * @property int $sector_id
 * @property string $quantity_sold
 * @property string $quantity_unit
 * @property string $thickness
 * @property string $width
 * @property string $color
 * @property string $printing_colors_number
 * @property int $embossed
 * @property int $perforated
 * @property string $core_id
 * @property string $business_terms
 * @property string $incoterms
 * @property string $payment
 * @property string $price
 * @property string $currency
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Competitor $competitor
 * @property Sector $sector
 */
class CompetitorFlexible extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%competitor_flexible}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['competitor_id', 'sector_id', 'embossed', 'perforated'], 'integer'],
            //[['product_type', 'quantity_sold', 'quantity_unit', 'thickness', 'width', 'color', 'printing_colors_number', 'core_id', 'business_terms', 'incoterms', 'payment', 'price', 'currency'], 'string', 'max' => 255],
           [['competitor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Competitor::className(), 'targetAttribute' => ['competitor_id' => 'id']],
            [['sector_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sector::className(), 'targetAttribute' => ['sector_id' => 'id']],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'competitor_id' => 'Competitor ID',
            'product_type' => 'Product Type',
            'sector_id' => 'Sector ID',
            'quantity_sold' => 'Quantity Sold',
            'quantity_unit' => 'Quantity Unit',
            'thickness' => 'Thickness',
            'width' => 'Width',
            'color' => 'Color',
            'printing_colors_number' => 'Printing Colors Number',
            'embossed' => 'Embossed',
            'perforated' => 'Perforated',
            'core_id' => 'Core ID',
            'business_terms' => 'Business Terms',
            'incoterms' => 'Incoterms',
            'payment' => 'Payment',
            'price' => 'Price',
            'currency' => 'Currency',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetitor()
    {
        return $this->hasOne(Competitor::className(), ['id' => 'competitor_id']);
    }

    public function getCompetitorFlexibleCustomer()
    {
        return $this->hasMany(CompetitorFlexibleCustomer::className(), ['competitor_flexible_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSector()
    {
        return $this->hasOne(Sector::className(), ['id' => 'sector_id']);
    }

    /**
     * {@inheritdoc}
     * @return CompetitorFlexibleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompetitorFlexibleQuery(get_called_class());
    }

    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        $list = parent::toArray($fields, $expand, $recursive);
        $list['competitorFlexibleCustomer'] = $this->getCompetitorFlexibleCustomer()->all();
        return $list;
    }
}
