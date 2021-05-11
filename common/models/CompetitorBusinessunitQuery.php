<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[CompetitorBusinessunit]].
 *
 * @see CompetitorBusinessunit
 */
class CompetitorBusinessunitQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CompetitorBusinessunit[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CompetitorBusinessunit|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
