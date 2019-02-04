<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%portfolio_sales_office}}".
 *
 * @property int $id
 * @property int $portfolio_id
 * @property int $sales_office_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Portfolio $portfolio
 * @property SalesOffice $salesOffice
 */
class PortfolioSalesOffice extends \cnd\core\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%portfolio_sales_office}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['portfolio_id', 'sales_office_id'], 'integer'],
            [['portfolio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Portfolio::className(), 'targetAttribute' => ['portfolio_id' => 'id']],
            [['sales_office_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalesOffice::className(), 'targetAttribute' => ['sales_office_id' => 'id']],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'portfolio_id' => 'Portfolio ID',
            'sales_office_id' => 'Sales Office ID',
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
    public function getSalesOffice()
    {
        return $this->hasOne(SalesOffice::className(), ['id' => 'sales_office_id']);
    }

    /**
     * {@inheritdoc}
     * @return PortfolioSalesOfficeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PortfolioSalesOfficeQuery(get_called_class());
    }
}
