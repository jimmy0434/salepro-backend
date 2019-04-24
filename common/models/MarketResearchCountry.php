<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%market_research_country}}".
 *
 * @property int $id
 * @property int $market_research_id
 * @property string $country
 * @property int $created_at
 * @property int $updated_at
 *
 * @property MarketResearch $marketResearch
 */
class MarketResearchCountry extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%market_research_country}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(),[
            [['market_research_id'], 'integer'],
            [['country'], 'string', 'max' => 255],
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
            'country' => 'Country',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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
     * @return MarketResearchCountryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MarketResearchCountryQuery(get_called_class());
    }
}
