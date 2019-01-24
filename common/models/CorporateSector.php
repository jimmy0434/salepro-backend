<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%corporate_sector}}".
 *
 * @property int $id
 * @property int $corporate_id
 * @property int $sector_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Corporate $corporate
 * @property Sector $sector
 */
class CorporateSector extends \cnd\core\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%corporate_sector}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['corporate_id', 'sector_id'], 'integer'],
            [['corporate_id'], 'exist', 'skipOnError' => true, 'targetClass' => Corporate::className(), 'targetAttribute' => ['corporate_id' => 'id']],
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
            'corporate_id' => 'Corporate ID',
            'sector_id' => 'Sector ID',
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
    public function getSector()
    {
        return $this->hasOne(Sector::className(), ['id' => 'sector_id']);
    }

    /**
     * {@inheritdoc}
     * @return CorporateSectorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CorporateSectorQuery(get_called_class());
    }
}
