<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%portfolio}}".
 *
 * @property int $id
 * @property string $uid
 * @property string $name
 * @property string $description
 * @property string $image
 * @property int $brochure_id
 * @property int $presentation_id
 * @property int $video_id
 * @property int $search_id
 * @property int $target
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Brand[] $brands
 * @property Corporate[] $corporates
 * @property PortfolioCompetitor[] $portfolioCompetitors
 * @property PortfolioLink[] $portfolioLinks
 * @property PortfolioNews[] $portfolioNews
 * @property Product[] $products
 * @property Sector[] $sectors
 */
class Portfolio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%portfolio}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image'], 'string'],
            [['brochure_id', 'presentation_id', 'video_id', 'search_id', 'target', 'created_at', 'updated_at'], 'integer'],
            [['created_at', 'updated_at'], 'required'],
            [['uid', 'name', 'description'], 'string', 'max' => 255],
            [['uid'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'name' => 'Name',
            'description' => 'Description',
            'image' => 'Image',
            'brochure_id' => 'Brochure ID',
            'presentation_id' => 'Presentation ID',
            'video_id' => 'Video ID',
            'search_id' => 'Search ID',
            'target' => 'Target',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrands()
    {
        return $this->hasMany(Brand::className(), ['portfolio_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCorporates()
    {
        return $this->hasMany(Corporate::className(), ['portfolio_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortfolioCompetitors()
    {
        return $this->hasMany(PortfolioCompetitor::className(), ['portfolio_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortfolioLinks()
    {
        return $this->hasMany(PortfolioLink::className(), ['portfolio_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortfolioNews()
    {
        return $this->hasMany(PortfolioNews::className(), ['portfolio_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['portfolio_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSectors()
    {
        return $this->hasMany(Sector::className(), ['portfolio_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return PortfolioQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PortfolioQuery(get_called_class());
    }
}
