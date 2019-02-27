<?php

namespace common\models;

use cnd\core\components\ActiveRecord;
use Yii;

/**
 * This is the model class for table "{{%business_unit_certification}}".
 *
 * @property int $id
 * @property int $business_unit_id
 * @property int $certification_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property BusinessUnit $businessUnit
 * @property Certification $certification
 */
class BusinessUnitCertification extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%business_unit_certification}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(),[
            [['business_unit_id', 'certification_id'], 'integer'],
            [['business_unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => BusinessUnit::className(), 'targetAttribute' => ['business_unit_id' => 'id']],
            [['certification_id'], 'exist', 'skipOnError' => true, 'targetClass' => Certification::className(), 'targetAttribute' => ['certification_id' => 'id']],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'business_unit_id' => 'Business Unit ID',
            'certification_id' => 'Certification ID',
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
    public function getCertification()
    {
        return $this->hasOne(Certification::className(), ['id' => 'certification_id']);
    }

    /**
     * {@inheritdoc}
     * @return BusinessUnitCertificationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BusinessUnitCertificationQuery(get_called_class());
    }
}
