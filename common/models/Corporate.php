<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%corporate}}".
 *
 * @property int $id
 * @property string $uid
 * @property int $portfolio_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Portfolio $portfolio
 * @property CorporateBusinessUnit[] $corporateBusinessUnits
 * @property CorporateFile[] $corporateFiles
 * @property CorporateSector[] $corporateSectors
 */
class Corporate extends \cnd\core\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%corporate}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['portfolio_id'], 'integer'],
            [['uid'], 'string', 'max' => 255],
            [['uid'], 'unique'],
            [['portfolio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Portfolio::className(), 'targetAttribute' => ['portfolio_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'portfolio_id' => 'Portfolio ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortfolio()
    {
        return $this->hasOne(Portfolio::className(), ['id' => 'portfolio_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCorporateBusinessUnits()
    {
        return $this->hasMany(CorporateBusinessUnit::className(), ['corporate_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCorporateFiles()
    {
        return $this->hasMany(CorporateFile::className(), ['corporate_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCorporateSectors()
    {
        return $this->hasMany(CorporateSector::className(), ['corporate_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return CorporateQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CorporateQuery(get_called_class());
    }
}
