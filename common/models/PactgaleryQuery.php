<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Pactgalery]].
 *
 * @see Pactgalery
 */
class PactgaleryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Pactgalery[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Pactgalery|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
