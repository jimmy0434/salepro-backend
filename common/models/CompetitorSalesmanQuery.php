<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[CompetitorSalesman]].
 *
 * @see CompetitorSalesman
 */
class CompetitorSalesmanQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CompetitorSalesman[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CompetitorSalesman|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
