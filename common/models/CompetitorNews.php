<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%competitor_news}}".
 *
 * @property int $id
 * @property int $competitor_id
 * @property string $url
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Competitor $competitor
 */
class CompetitorNews extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%competitor_news}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['competitor_id'], 'integer'],
            //[['url'], 'string'],
            [['competitor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Competitor::className(), 'targetAttribute' => ['competitor_id' => 'id']],
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
            'url' => 'Url',
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
     * {@inheritdoc}
     * @return CompetitorNewsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompetitorNewsQuery(get_called_class());
    }
}
