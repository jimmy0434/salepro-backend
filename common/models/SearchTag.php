<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%search_tag}}".
 *
 * @property int $id
 * @property int $search_id
 * @property int $tag_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Tag $tag
 * @property Search $search
 */
class SearchTag extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%search_tag}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['search_id', 'tag_id'], 'integer'],
            [['tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tag::className(), 'targetAttribute' => ['tag_id' => 'id']],
            [['search_id'], 'exist', 'skipOnError' => true, 'targetClass' => Search::className(), 'targetAttribute' => ['search_id' => 'id']],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'search_id' => 'Search ID',
            'tag_id' => 'Tag ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tag::className(), ['id' => 'tag_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSearch()
    {
        return $this->hasOne(Search::className(), ['id' => 'search_id']);
    }

    /**
     * {@inheritdoc}
     * @return SearchTagQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SearchTagQuery(get_called_class());
    }
}
