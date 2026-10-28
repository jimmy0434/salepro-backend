<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mpk_competitor_businessunit".
 *
 * @property int $id
 * @property int $competitor_id
 * @property string $value
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Competitor $competitor
 */
class CompetitorBusinessunit extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mpk_competitor_businessunit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['competitor_id', 'created_at', 'updated_at'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [['competitor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Competitor::className(), 'targetAttribute' => ['competitor_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'competitor_id' => 'Competitor ID',
            'value' => 'Value',
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
     * @return CompetitorBusinessunitQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompetitorBusinessunitQuery(get_called_class());
        
        
    }
}
