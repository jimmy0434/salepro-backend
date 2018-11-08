<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Salesman]].
 *
 * @see Salesman
 */
class SalesmanQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Salesman[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Salesman|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
