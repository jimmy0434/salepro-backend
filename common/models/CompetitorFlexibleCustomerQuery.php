<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[CompetitorFlexibleCustomer]].
 *
 * @see CompetitorFlexibleCustomer
 */
class CompetitorFlexibleCustomerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CompetitorFlexibleCustomer[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CompetitorFlexibleCustomer|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
