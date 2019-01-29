<?php

namespace common\models;

use cnd\core\components\ActiveRecord;
use Yii;

/**
 * This is the model class for table "{{%market_research_product}}".
 *
 * @property int $id
 * @property int $market_research_id
 * @property int $product_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Product $product
 * @property MarketResearch $marketResearch
 */
class MarketResearchProduct extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%market_research_product}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['market_research_id', 'product_id'], 'integer'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['market_research_id'], 'exist', 'skipOnError' => true, 'targetClass' => MarketResearch::className(), 'targetAttribute' => ['market_research_id' => 'id']],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'market_research_id' => 'Market Research',
            'product_id' => 'Product',
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
    public function getMarketResearch()
    {
        return $this->hasOne(MarketResearch::className(), ['id' => 'market_research_id']);
    }

    /**
     * {@inheritdoc}
     * @return MarketResearchProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MarketResearchProductQuery(get_called_class());
    }
}
