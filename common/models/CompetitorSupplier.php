<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%competitor_supplier}}".
 *
 * @property int $id
 * @property int $competitor_id
 * @property string $raw_material
 * @property string $supplier_name
 * @property string $country
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Competitor $competitor
 */
class CompetitorSupplier extends \cnd\core\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%competitor_supplier}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['competitor_id'], 'integer'],
            //[['raw_material', 'supplier_name', 'country'], 'string', 'max' => 255],
            [['competitor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Competitor::className(), 'targetAttribute' => ['competitor_id' => 'id']],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'competitor_id' => 'Competitor ID',
            'raw_material' => 'Raw Material',
            'supplier_name' => 'Supplier Name',
            'country' => 'Country',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetitor()
    {
        return $this->hasOne(Competitor::className(), ['id' => 'competitor_id']);
    }

    /**
     * {@inheritdoc}
     * @return CompetitorSupplierQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompetitorSupplierQuery(get_called_class());
    }
}
