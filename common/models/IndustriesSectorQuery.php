<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[IndustriesSector]].
 *
 * @see IndustriesSector
 */
class IndustriesSectorQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return IndustriesSector[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return IndustriesSector|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
