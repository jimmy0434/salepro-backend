<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%sector_business_unit}}".
 *
 * @property int $id
 * @property int $sector_id
 * @property int $business_unit_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Sector $sector
 * @property BusinessUnit $businessUnit
 */
class SectorBusinessUnit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sector_business_unit}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sector_id', 'business_unit_id', 'created_at', 'updated_at'], 'integer'],
            [['created_at', 'updated_at'], 'required'],
            [['sector_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sector::className(), 'targetAttribute' => ['sector_id' => 'id']],
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
            'sector_id' => 'Sector ID',
            'business_unit_id' => 'Business Unit ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSector()
    {
        return $this->hasOne(Sector::className(), ['id' => 'sector_id']);
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
     * @return SectorBusinessUnitQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SectorBusinessUnitQuery(get_called_class());
    }
}
