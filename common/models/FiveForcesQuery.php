<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[FiveForces]].
 *
 * @see FiveForces
 */
class FiveForcesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return FiveForces[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return FiveForces|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
