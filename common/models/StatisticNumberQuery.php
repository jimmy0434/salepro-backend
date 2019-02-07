<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[StatisticNumber]].
 *
 * @see StatisticNumber
 */
class StatisticNumberQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return StatisticNumber[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return StatisticNumber|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
