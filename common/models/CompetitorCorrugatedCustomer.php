<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mpk_competitor_corrugated_customer".
 *
 * @property int $id
 * @property int $competitor_id
 * @property int $competitor_corrugated_id
 * @property string $name
 * @property string $country
 * @property string $share_percentage
 * @property int $created_at
 * @property int $updated_at
 *
 * @property CompetitorCorrugatedCustomer $competitorCorrugated
 * @property CompetitorCorrugatedCustomer[] $competitorCorrugatedCustomers
 * @property Competitor $competitor
 */
class CompetitorCorrugatedCustomer extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%competitor_corrugated_customer}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
          //  [['competitor_id', 'competitor_corrugated_id', 'created_at', 'updated_at'], 'integer'],
           // [['created_at', 'updated_at'], 'required'],
          //  [['name', 'country', 'share_percentage'], 'string', 'max' => 255],
           //[['competitor_corrugated_id'], 'exist', 'skipOnError' => true, 'targetClass' => CompetitorCorrugatedCustomer::className(), 'targetAttribute' => ['competitor_corrugated_id' => 'id']],
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
            'competitor_corrugated_id' => 'Competitor Corrugated ID',
            'name' => 'Name',
            'country' => 'Country',
            'share_percentage' => 'Share Percentage'
        
        ];
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetitorCorrugated()
    {
        return $this->hasOne(CompetitorCorrugated::className(), ['id' => 'competitor_corrugated_id']);
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
     * @return CompetitorCorrugatedCustomerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompetitorCorrugatedCustomerQuery(get_called_class());
    }
}
