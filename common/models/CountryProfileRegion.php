<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mpk_country_profile_region".
 *
 * @property int $id
 * @property int $country_profile_id
 * @property string $region
 * @property int $created_at
 * @property int $updated_at
 *
 * @property CountryProfile $countryProfile
 */
class CountryProfileRegion extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mpk_country_profile_region';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['country_profile_id'], 'integer'],
            [['region'], 'string', 'max' => 255],
            [['country_profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => CountryProfile::className(), 'targetAttribute' => ['country_profile_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'country_profile_id' => 'Country Profile ID',
            'region' => 'Region',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountryProfile()
    {
        return $this->hasOne(CountryProfile::className(), ['id' => 'country_profile_id']);
    }

    /**
     * {@inheritdoc}
     * @return CountryProfileRegionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CountryProfileRegionQuery(get_called_class());
    }
}
