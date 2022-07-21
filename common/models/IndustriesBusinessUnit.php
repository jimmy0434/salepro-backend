<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mpk_industries_business_unit".
 *
 * @property int $id
 * @property int $industries_id
 * @property int $business_unit_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property BusinessUnit $businessUnit
 * @property Industries $industries
 */
class IndustriesBusinessUnit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mpk_industries_business_unit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['industries_id', 'business_unit_id', 'created_at', 'updated_at'], 'integer'],
            [['business_unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => BusinessUnit::className(), 'targetAttribute' => ['business_unit_id' => 'id']],
            [['industries_id'], 'exist', 'skipOnError' => true, 'targetClass' => Industries::className(), 'targetAttribute' => ['industries_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'industries_id' => 'Industries ID',
            'business_unit_id' => 'Business Unit ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessUnit()
    {
        return $this->hasOne(BusinessUnit::className(), ['id' => 'business_unit_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndustries()
    {
        return $this->hasOne(Industries::className(), ['id' => 'industries_id']);
    }

    /**
     * {@inheritdoc}
     * @return IndustriesBusinessUnitQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new IndustriesBusinessUnitQuery(get_called_class());
    }
}
