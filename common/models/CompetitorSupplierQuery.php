<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[CompetitorSupplier]].
 *
 * @see CompetitorSupplier
 */
class CompetitorSupplierQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CompetitorSupplier[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CompetitorSupplier|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
