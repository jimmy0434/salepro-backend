<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%competitor_social}}".
 *
 * @property int $id
 * @property int $competitor_id
 * @property string $social_media
 * @property string $url
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Competitor $competitor
 */
class CompetitorSocial extends \cnd\core\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%competitor_social}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['competitor_id'], 'integer'],
            [['url'], 'string'],
            [['social_media'], 'string', 'max' => 255],
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
            'social_media' => 'Social Media',
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
     * @return CompetitorSocialQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompetitorSocialQuery(get_called_class());
    }
}
