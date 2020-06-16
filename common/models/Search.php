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
 * @property Competitor $competitor
 * @property MarketResearch $marketResearch
 * @property Portfolio $portfolio
 * @property SearchTag[] $searchTags
 */
class Search extends \common\components\ActiveRecord
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
        return array_merge(parent::rules(), [
            [['text'], 'string'],
            [['title'], 'string', 'max' => 255],
        ]);
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
    public function getCompetitor()
    {
        return $this->hasOne(Competitor::className(), ['search_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMarketResearche()
    {
        return $this->hasOne(MarketResearch::className(), ['search_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortfolio()
    {
        return $this->hasOne(Portfolio::className(), ['search_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSearchTags()
    {
        return $this->hasMany(SearchTag::className(), ['search_id' => 'id']);
    }

    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->via('searchTags');
    }

    /**
     * {@inheritdoc}
     * @return SearchQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SearchQuery(get_called_class());
    }

    // $target - uid
    // $title - entity name
    public static function updateRecord($tags, $target, $title, $text = null)
    {
        $model = static::find()->where(['target' => $target])->one();
        if (!$model) {
            $model = new static();
            $model->target = $target;
        }
        $model->title = $title;
        $model->text = $text;
        $model->save();

        $tagsRels = $model->searchTags;
        if (!empty($tagsRels) && is_array($tagsRels)) {
            foreach ($tagsRels as $tagRel) {
                $tagRel->delete();
            }
        }

        // adding tags to search_tag table
        if (!empty($tags) && is_array($tags)) {
            foreach ($tags as $tagId) {
                $tag = new SearchTag();
                $tag->tag_id = $tagId;
                $tag->search_id = $model->id;
                $tag->save();
            }
        }
        return $model;
    }

    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        $list = parent::toArray($fields, $expand, $recursive);
        $t = explode('-', $this->target);
        if (isset($t[0])) {
            $list['target'] = [
                'type' => $t[0] == "portfolio" && $this->portfolio ? strtolower($this->portfolio->target_label) : $t[0],
                'uid' => $this->target,
            ];
        }
        return $list;
    }
}
