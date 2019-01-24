<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%corporate_business_unit}}".
 *
 * @property int $id
 * @property int $corporate_id
 * @property int $business_unit_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Corporate $corporate
 * @property BusinessUnit $businessUnit
 */
class CorporateBusinessUnit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%corporate_business_unit}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['corporate_id', 'business_unit_id', 'created_at', 'updated_at'], 'integer'],
            [['created_at', 'updated_at'], 'required'],
            [['corporate_id'], 'exist', 'skipOnError' => true, 'targetClass' => Corporate::className(), 'targetAttribute' => ['corporate_id' => 'id']],
            [['business_unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => BusinessUnit::className(), 'targetAttribute' => ['business_unit_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'corporate_id' => 'Corporate ID',
            'business_unit_id' => 'Business Unit ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCorporate()
    {
        return $this->hasOne(Corporate::className(), ['id' => 'corporate_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessUnit()
    {
        return $this->hasOne(BusinessUnit::className(), ['id' => 'business_unit_id']);
    }

    /**
     * {@inheritdoc}
     * @return CorporateBusinessUnitQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CorporateBusinessUnitQuery(get_called_class());
    }
}
