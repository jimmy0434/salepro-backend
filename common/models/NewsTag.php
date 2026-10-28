<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mpk_news_tag".
 *
 * @property int $id
 * @property int $news_id
 * @property string $tag
 * @property int $created_at
 * @property int $updated_at
 *
 * @property News $news
 */
class NewsTag extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mpk_news_tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['news_id'], 'integer'],
            [['tag'], 'string', 'max' => 255],
            [['news_id'], 'exist', 'skipOnError' => true, 'targetClass' => News::className(), 'targetAttribute' => ['news_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'news_id' => 'News ID',
            'tag' => 'Tag',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasOne(News::className(), ['id' => 'news_id']);
    }

    /**
     * {@inheritdoc}
     * @return NewsTagQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NewsTagQuery(get_called_class());
    }
}
