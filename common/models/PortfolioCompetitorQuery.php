<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[PortfolioCompetitor]].
 *
 * @see PortfolioCompetitor
 */
class PortfolioCompetitorQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PortfolioCompetitor[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PortfolioCompetitor|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
