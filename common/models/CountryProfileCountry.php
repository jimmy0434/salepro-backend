<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mpk_country_profile_country".
 *
 * @property int $id
 * @property int $country_profile_id
 * @property string $country
 * @property int $created_at
 * @property int $updated_at
 *
 * @property CountryProfile $countryProfile
 */
class CountryProfileCountry extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mpk_country_profile_country';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['country_profile_id'], 'integer'],
            [['country'], 'string', 'max' => 255],
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
            'country' => 'Country',
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
     * @return CountryProfileCountryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CountryProfileCountryQuery(get_called_class());
    }
}
