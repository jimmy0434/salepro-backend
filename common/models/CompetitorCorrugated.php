<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mpk_competitor_corrugated".
 *
 * @property int $id
 * @property int $competitor_id
 * @property string $product_type
 * @property string $quantity_sold
 * @property string $quantity_unit
 * @property string $material
 * @property string $flute_type
 * @property string $thickness
 * @property string $strength_test
 * @property string $dimensions
 * @property int $Weight
 * @property int $Printing
 * @property string $coating
 * @property string $surface_finish
 * @property string $color
 * @property string $volume
 * @property string $business_terms
 * @property string $incoterms
 * @property string $payment
 * @property string $price
 * @property string $currency
 * @property int $created_at
 * @property int $updated_at
 *

 * @property Competitor $competitor
 */
class CompetitorCorrugated extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%competitor_corrugated}}';
      
        
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           // [['competitor_id', 'sector_id', 'Weight', 'Printing', 'created_at', 'updated_at'], 'integer'],
          //  [['created_at', 'updated_at'], 'required'],
          //  [['product_type', 'quantity_sold', 'quantity_unit', 'material', 'flute_type', 'thickness', 'strength_test', 'dimensions', 'coating', 'surface_finish', 'color', 'volume', 'business_terms', 'incoterms', 'payment', 'price', 'currency'], 'string', 'max' => 255],
          //  [['sector_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sector::className(), 'targetAttribute' => ['sector_id' => 'id']],
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
            'product_type' => 'Product Type',
            'quantity_sold' => 'Quantity Sold',
            'quantity_unit' => 'Quantity Unit',
            'material' => 'Material',
            'flute_type' => 'Flute Type',
            'thickness' => 'Thickness',
            'strength_test' => 'Strength Test',
            'dimensions' => 'Dimensions',
            'weight' => 'Weight',
            'printing' => 'Printing',
            'coating' => 'Coating',
            'surface_finish' => 'Surface Finish',
            'color' => 'Color',
            'volume' => 'Volume',
            'business_terms' => 'Business Terms',
            'incoterms' => 'Incoterms',
            'payment' => 'Payment',
            'price' => 'Price',
            

        ];
    }

   
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetitor()
    {
        return $this->hasOne(Competitor::className(), ['id' => 'competitor_id']);
    }

    public function getCompetitorCorrugatedCustomer()
    {
        return $this->hasMany(CompetitorCorrugatedCustomer::className(), ['competitor_corrugated_id' => 'id']);
    }

   
    /**
     * {@inheritdoc}
     * @return CompetitorCorrugatedQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompetitorCorrugatedQuery(get_called_class());
    }

    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        $list = [parent::toArray($fields, $expand, $recursive)];
      
        $list['competitorCorrugatedCustomer'] = $this->getCompetitorCorrugatedCustomer()->all();
        return $list;
    }
}
