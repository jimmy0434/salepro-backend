<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%competitor}}".
 *
 * @property int $id
 * @property string $name
 * @property string $image
 * @property string $market_presence
 * @property string $year
 * @property string $product
 * @property string $business_unit
 * @property int $form_id
 * @property int $form_record_id
 * @property int $search_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Search $search
 * @property Form $form
 * @property PortfolioCompetitor[] $portfolioCompetitors
 */
class Competitor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%competitor}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image'], 'string'],
            [['form_id', 'form_record_id', 'search_id'], 'integer'],
            [['name', 'market_presence', 'year', 'product', 'business_unit'], 'string', 'max' => 255],
            [['search_id'], 'exist', 'skipOnError' => true, 'targetClass' => Search::className(), 'targetAttribute' => ['search_id' => 'id']],
            [['form_id'], 'exist', 'skipOnError' => true, 'targetClass' => Form::className(), 'targetAttribute' => ['form_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'image' => 'Image',
            'market_presence' => 'Market Presence',
            'year' => 'Year',
            'product' => 'Product',
            'business_unit' => 'Business Unit',
            'form_id' => 'Form ID',
            'form_record_id' => 'Form Record ID',
            'search_id' => 'Search ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSearch()
    {
        return $this->hasOne(Search::className(), ['id' => 'search_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForm()
    {
        return $this->hasOne(Form::className(), ['id' => 'form_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortfolioCompetitors()
    {
        return $this->hasMany(PortfolioCompetitor::className(), ['competitor_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return CompetitorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompetitorQuery(get_called_class());
    }
}
