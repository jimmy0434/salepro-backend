<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%portfolio_link}}".
 *
 * @property int $id
 * @property int $portfolio_id
 * @property string $image
 * @property string $url
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Portfolio $portfolio
 */
class PortfolioLink extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%portfolio_link}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['portfolio_id'], 'integer'],
            [['image', 'url'], 'string'],
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
            'image' => 'Image',
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
     * @return PortfolioLinkQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PortfolioLinkQuery(get_called_class());
    }
}
