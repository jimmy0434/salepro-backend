<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mpk_news_sector".
 *
 * @property int $id
 * @property int $news_id
 * @property string $sector
 * @property int $created_at
 * @property int $updated_at
 *
 * @property News $news
 */
class NewsSector extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mpk_news_sector';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['news_id'], 'integer'],
            [['sector'], 'string', 'max' => 255],
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
            'sector' => 'Sector',
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
     * @return NewsSectorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NewsSectorQuery(get_called_class());
    }
}
