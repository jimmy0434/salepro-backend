<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%portfolio_news}}".
 *
 * @property int $id
 * @property int $portfolio_id
 * @property string $url
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Portfolio $portfolio
 */
class PortfolioNews extends \cnd\core\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%portfolio_news}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['portfolio_id'], 'integer'],
            [['url'], 'string'],
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
            'url' => 'Url',
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
     * {@inheritdoc}
     * @return PortfolioNewsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PortfolioNewsQuery(get_called_class());
    }
}
