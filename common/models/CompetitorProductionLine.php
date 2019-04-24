<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%competitor_production_line}}".
 *
 * @property int $id
 * @property int $competitor_id
 * @property string $production_line
 * @property string $colors_number
 * @property string $layers_number
 * @property string $brand_line
 * @property string $output
 * @property string $unit
 * @property string $width
 * @property string $machines_number
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Competitor $competitor
 */
class CompetitorProductionLine extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%competitor_production_line}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['competitor_id'], 'integer'],
            //[['production_line', 'colors_number', 'layers_number', 'brand_line', 'output', 'unit', 'width', 'machines_number'], 'string', 'max' => 255],
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
            'production_line' => 'Production Line',
            'colors_number' => 'Colors Number',
            'layers_number' => 'Layers Number',
            'brand_line' => 'Brand Line',
            'output' => 'Output',
            'unit' => 'Unit',
            'width' => 'Width',
            'machines_number' => 'Machines Number',
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
     * @return CompetitorProductionLineQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompetitorProductionLineQuery(get_called_class());
    }
}
