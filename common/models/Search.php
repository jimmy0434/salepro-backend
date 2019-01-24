<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%search}}".
 *
 * @property int $id
 * @property string $title
 * @property string $text
 * @property int $target
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Competitor[] $competitors
 * @property MarketResearch[] $marketResearches
 * @property SearchTag[] $searchTags
 */
class Search extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%search}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text'], 'string'],
            [['target', 'created_at', 'updated_at'], 'integer'],
            [['created_at', 'updated_at'], 'required'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'text' => 'Text',
            'target' => 'Target',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetitors()
    {
        return $this->hasMany(Competitor::className(), ['search_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMarketResearches()
    {
        return $this->hasMany(MarketResearch::className(), ['search_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSearchTags()
    {
        return $this->hasMany(SearchTag::className(), ['search_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return SearchQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SearchQuery(get_called_class());
    }
}
