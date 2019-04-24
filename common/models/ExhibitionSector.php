<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mpk_exhibition_sector".
 *
 * @property int $id
 * @property int $exhibition_id
 * @property int $sector_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Exhibition $exhibition
 * @property Sector $sector
 */
class ExhibitionSector extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%exhibition_sector}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['exhibition_id', 'sector_id'], 'integer'],
            [['exhibition_id'], 'exist', 'skipOnError' => true, 'targetClass' => Exhibition::className(), 'targetAttribute' => ['exhibition_id' => 'id']],
            [['sector_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sector::className(), 'targetAttribute' => ['sector_id' => 'id']],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'exhibition_id' => 'Exhibition ID',
            'sector_id' => 'Sector ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExhibition()
    {
        return $this->hasOne(Exhibition::className(), ['id' => 'exhibition_id']);
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
     * @return ExhibitionSectorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ExhibitionSectorQuery(get_called_class());
    }
}
