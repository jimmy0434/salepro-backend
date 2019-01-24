<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%portfolio_competitor}}".
 *
 * @property int $id
 * @property int $portfolio_id
 * @property int $competitor_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Competitor $competitor
 * @property Portfolio $portfolio
 */
class PortfolioCompetitor extends \cnd\core\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%portfolio_competitor}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['portfolio_id', 'competitor_id'], 'integer'],
            [['competitor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Competitor::className(), 'targetAttribute' => ['competitor_id' => 'id']],
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
            'portfolio_id' => 'Portfolio ID',
            'competitor_id' => 'Competitor ID',
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
     * @return \yii\db\ActiveQuery
     */
    public function getPortfolio()
    {
        return $this->hasOne(Portfolio::className(), ['id' => 'portfolio_id']);
    }

    /**
     * {@inheritdoc}
     * @return PortfolioCompetitorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PortfolioCompetitorQuery(get_called_class());
    }
}
