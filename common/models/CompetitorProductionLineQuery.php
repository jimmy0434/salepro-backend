<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[CompetitorProductionLine]].
 *
 * @see CompetitorProductionLine
 */
class CompetitorProductionLineQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CompetitorProductionLine[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CompetitorProductionLine|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
