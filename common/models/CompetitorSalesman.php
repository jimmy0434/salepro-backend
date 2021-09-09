<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mpk_competitor_salesman".
 *
 * @property int $id
 * @property int $competitor_id
 * @property int $value
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Salesman $value0
 * @property Competitor $competitor
 */
class CompetitorSalesman extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mpk_competitor_salesman';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['competitor_id', 'value', 'created_at', 'updated_at'], 'integer'],
            [['value'], 'exist', 'skipOnError' => true, 'targetClass' => Salesman::className(), 'targetAttribute' => ['value' => 'id']],
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
    public function getValue0()
    {
        return $this->hasOne(Salesman::className(), ['id' => 'value']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetitor()
    {
        return $this->hasOne(Competitor::className(), ['id' => 'competitor_id']);
    }
     /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return CompetitorSalesmanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompetitorSalesmanQuery(get_called_class());
        
    }
}
