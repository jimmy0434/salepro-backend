<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%exhibition_item}}".
 *
 * @property int $id
 * @property int $exhibition_id
 * @property int $by
 * @property int $created_at
 * @property int $updated_at
 *
 * @property array $by_list
 * @property array $by_values
 * @property string $by_label
 *
 * @property Exhibition $exhibition
 * @property ExhibitionItemProduct[] $exhibitionItemProducts
 */
class ExhibitionItem extends \cnd\core\components\ActiveRecord
{
    const BY_BRAND = 1;
    const BY_SECTOR = 2;
    const BY_PRODUCT = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%exhibition_item}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['exhibition_id', 'by'], 'integer'],
            [['exhibition_id'], 'exist', 'skipOnError' => true, 'targetClass' => Exhibition::className(), 'targetAttribute' => ['exhibition_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'exhibition_id' => 'Exhibition ID',
            'by' => 'By',
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
    public function getExhibitionItemProducts()
    {
        return $this->hasMany(ExhibitionItemProduct::className(), ['exhibition_item_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ExhibitionItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ExhibitionItemQuery(get_called_class());
    }
}
