<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%competitor_packaging}}".
 *
 * @property int $id
 * @property int $competitor_id
 * @property string $product_type
 * @property int $sector_id
 * @property string $quantity_sold
 * @property string $quantity_unit
 * @property string $material
 * @property string $weight
 * @property string $diameter
 * @property string $color
 * @property string $height
 * @property string $neck
 * @property string $ctn_volume
 * @property string $business_terms
 * @property string $incoterms
 * @property string $payment
 * @property string $price
 * @property string $currency
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Sector $sector
 * @property Competitor $competitor
 */
class CompetitorPackaging extends \cnd\core\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%competitor_packaging}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['competitor_id', 'sector_id'], 'integer'],
            //[['product_type', 'quantity_sold', 'quantity_unit', 'material', 'weight', 'diameter', 'color', 'height', 'neck', 'ctn_volume', 'business_terms', 'incoterms', 'payment', 'price', 'currency'], 'string', 'max' => 255],
            [['sector_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sector::className(), 'targetAttribute' => ['sector_id' => 'id']],
            [['competitor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Competitor::className(), 'targetAttribute' => ['competitor_id' => 'id']],
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
            'material' => 'Material',
            'weight' => 'Weight',
            'diameter' => 'Diameter',
            'color' => 'Color',
            'height' => 'Height',
            'neck' => 'Neck',
            'ctn_volume' => 'Ctn Volume',
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
    public function getSector()
    {
        return $this->hasOne(Sector::className(), ['id' => 'sector_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetitor()
    {
        return $this->hasOne(Competitor::className(), ['id' => 'competitor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetitorPackagingCustomer()
    {
        return $this->hasMany(CompetitorPackagingCustomer::className(), ['competitor_packaging_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return CompetitorPackagingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompetitorPackagingQuery(get_called_class());
    }

    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        $list = parent::toArray($fields, $expand, $recursive);
        $list['competitorPackagingCustomer'] = $this->getCompetitorPackagingCustomer()->all();
        return $list;
    }
}
