<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mpk_exhibition_region".
 *
 * @property int $id
 * @property int $exhibition_id
 * @property string $region
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Exhibition $exhibition
 */
class ExhibitionRegion extends \cnd\core\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mpk_exhibition_region';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['exhibition_id'], 'integer'],
            [['region'], 'string', 'max' => 255],
            [['exhibition_id'], 'exist', 'skipOnError' => true, 'targetClass' => Exhibition::className(), 'targetAttribute' => ['exhibition_id' => 'id']],
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
            'region' => 'Region',
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
     * {@inheritdoc}
     * @return ExhibitionRegionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ExhibitionRegionQuery(get_called_class());
    }
}
