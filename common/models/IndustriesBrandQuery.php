<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[IndustriesBrand]].
 *
 * @see IndustriesBrand
 */
class IndustriesBrandQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return IndustriesBrand[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return IndustriesBrand|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
