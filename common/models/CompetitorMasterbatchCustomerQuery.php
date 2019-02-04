<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[CompetitorMasterbatchCustomer]].
 *
 * @see CompetitorMasterbatchCustomer
 */
class CompetitorMasterbatchCustomerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CompetitorMasterbatchCustomer[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CompetitorMasterbatchCustomer|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
