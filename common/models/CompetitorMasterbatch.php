<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%competitor_masterbatch}}".
 *
 * @property int $id
 * @property int $competitor_id
 * @property string $product_type
 * @property int $sector_id
 * @property string $quantity_sold
 * @property string $quantity_unit
 * @property string $active_ingredient
 * @property string $mfi
 * @property string $resin_type
 * @property string $ink_type
 * @property string $outdoor
 * @property string $food_grade
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
class CompetitorMasterbatch extends \cnd\core\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%competitor_masterbatch}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(),[
            [['competitor_id', 'sector_id'], 'integer'],
            //[['product_type', 'quantity_sold', 'quantity_unit', 'active_ingredient', 'mfi', 'resin_type', 'ink_type', 'outdoor', 'food_grade', 'business_terms', 'incoterms', 'payment', 'price', 'currency'], 'string', 'max' => 255],
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
            'active_ingredient' => 'Active Ingredient',
            'mfi' => 'Mfi',
            'resin_type' => 'Resin Type',
            'ink_type' => 'Ink Type',
            'outdoor' => 'Outdoor',
            'food_grade' => 'Food Grade',
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
    public function getCompetitorMasterbatchCustomer()
    {
        return $this->hasMany(CompetitorMasterbatchCustomer::className(), ['competitor_masterbatch_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return CompetitorMasterbatchQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompetitorMasterbatchQuery(get_called_class());
    }

    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        $list = parent::toArray($fields, $expand, $recursive);
        $list['competitorMasterbatchCustomer'] = $this->getCompetitorMasterbatchCustomer()->all();
        return $list;
    }
}
