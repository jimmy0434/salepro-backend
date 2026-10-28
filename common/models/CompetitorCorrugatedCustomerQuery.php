<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[CompetitorCorrugatedCustomer]].
 *
 * @see CompetitorCorrugatedCustomer
 */
class CompetitorCorrugatedCustomerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CompetitorCorrugatedCustomer[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CompetitorCorrugatedCustomer|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
