<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[IndustriesBusinessUnit]].
 *
 * @see IndustriesBusinessUnit
 */
class IndustriesBusinessUnitQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return IndustriesBusinessUnit[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return IndustriesBusinessUnit|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
