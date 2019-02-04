<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[CompetitorPackagingCustomer]].
 *
 * @see CompetitorPackagingCustomer
 */
class CompetitorPackagingCustomerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CompetitorPackagingCustomer[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CompetitorPackagingCustomer|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
