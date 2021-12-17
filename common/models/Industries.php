<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "industries".
 *
 * @property int $id
 * @property string $uid
 * @property int $portfolio_id
 */
class Industries extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'industries';
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductIndustries()
    {
        return $this->hasMany(ProductIndustries::className(), ['industries_id' => 'id']);
    }

    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'product_id'])->via('productIndustriess');
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
    public function getIndustriesSector()
    {
        return $this->hasMany(IndustiersSector::className(), ['industries_id' => 'id']);
    }

    public function getSectors()
    {
        return $this->hasMany(Sector::className(), ['id' => 'sector+id'])->via('industriesSector');
    }

    /**
     * {@inheritdoc}
     * @return IndustriesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new IndustriesQuery(get_called_class());
    }
    public static function relateToPortfolio($portfolioId)
    {
        $model = static::find()->where(['portfolio_id' => $portfolioId])->one();
        if (!$model) {
            $model = new static();
            $model->uid = uniqid('industries-', true);
            $model->portfolio_id = $portfolioId;
            $model->save();
        }
    }
}
