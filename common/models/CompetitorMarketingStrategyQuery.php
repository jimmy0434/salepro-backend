<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[CompetitorMarketingStrategy]].
 *
 * @see CompetitorMarketingStrategy
 */
class CompetitorMarketingStrategyQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CompetitorMarketingStrategy[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CompetitorMarketingStrategy|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
