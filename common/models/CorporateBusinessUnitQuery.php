<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[CorporateBusinessUnit]].
 *
 * @see CorporateBusinessUnit
 */
class CorporateBusinessUnitQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CorporateBusinessUnit[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CorporateBusinessUnit|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
