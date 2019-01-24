<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[PortfolioLink]].
 *
 * @see PortfolioLink
 */
class PortfolioLinkQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PortfolioLink[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PortfolioLink|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
