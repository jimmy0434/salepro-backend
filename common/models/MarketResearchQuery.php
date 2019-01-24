<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[MarketResearch]].
 *
 * @see MarketResearch
 */
class MarketResearchQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MarketResearch[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MarketResearch|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
