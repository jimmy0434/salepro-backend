<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[PortfolioNews]].
 *
 * @see PortfolioNews
 */
class PortfolioNewsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PortfolioNews[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PortfolioNews|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
