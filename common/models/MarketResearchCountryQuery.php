<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[MarketResearchCountry]].
 *
 * @see MarketResearchCountry
 */
class MarketResearchCountryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MarketResearchCountry[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MarketResearchCountry|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
