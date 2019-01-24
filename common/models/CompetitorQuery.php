<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Competitor]].
 *
 * @see Competitor
 */
class CompetitorQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Competitor[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Competitor|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
