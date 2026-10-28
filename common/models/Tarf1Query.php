<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Tarf1]].
 *
 * @see Tarf1
 */
class Tarf1Query extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Tarf1[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Tarf1|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
