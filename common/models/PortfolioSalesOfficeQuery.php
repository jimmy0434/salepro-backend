<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[PortfolioSalesOffice]].
 *
 * @see PortfolioSalesOffice
 */
class PortfolioSalesOfficeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PortfolioSalesOffice[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PortfolioSalesOffice|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
