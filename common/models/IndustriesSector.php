<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mpk_industries_sector".
 *
 * @property int $id
 * @property int $industries_id
 * @property int $sector_id
 *
 * @property Industries $industries
 * @property Sector $sector
 */
class IndustriesSector extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mpk_industries_sector';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['industries_id', 'sector_id'], 'integer'],
            [['industries_id'], 'exist', 'skipOnError' => true, 'targetClass' => Industries::className(), 'targetAttribute' => ['industries_id' => 'id']],
            [['sector_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sector::className(), 'targetAttribute' => ['sector_id' => 'id']],
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
            'sector_id' => 'Sector ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndustries()
    {
        return $this->hasOne(Industries::className(), ['id' => 'industries_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSector()
    {
        return $this->hasOne(Sector::className(), ['id' => 'sector_id']);
    }

    /**
     * {@inheritdoc}
     * @return IndustriesSectorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new IndustriesSectorQuery(get_called_class());
    }
}
