<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mpk_competitor_vga".
 *
 * @property int $id
 * @property int $competitor_id
 * @property string $country
 * @property string $product_type
 * @property string $quality
 * @property string $brand_equity
 * @property string $problem_solving_response
 * @property string $timely_delivery
 * @property string $lead_time
 * @property string $customer_relationship
 * @property string $payment_facilities
 * @property string $price
 * @property string $market_share_percentage
 *
 * @property Competitor $competitor
 */
class CompetitorVga extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mpk_competitor_vga';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['competitor_id'], 'integer'],
            [['country', 'product_type', 'quality', 'brand_equity', 'problem_solving_response', 'timely_delivery', 'lead_time', 'customer_relationship', 'payment_facilities', 'price', 'market_share_percentage'], 'string', 'max' => 255],
            [['competitor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Competitor::className(), 'targetAttribute' => ['competitor_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'competitor_id' => 'Competitor ID',
            'country' => 'Country',
            'product_type' => 'Product Type',
            'quality' => 'Quality',
            'brand_equity' => 'Brand Equity',
            'problem_solving_response' => 'Problem Solving Response',
            'timely_delivery' => 'Timely Delivery',
            'lead_time' => 'Lead Time',
            'customer_relationship' => 'Customer Relationship',
            'payment_facilities' => 'Payment Facilities',
            'price' => 'Price',
            'market_share_percentage' => 'Market Share Percentage',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetitor()
    {
        return $this->hasOne(Competitor::className(), ['id' => 'competitor_id']);
    }

    /**
     * {@inheritdoc}
     * @return CompetitorVgaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompetitorVgaQuery(get_called_class());
    }
}
