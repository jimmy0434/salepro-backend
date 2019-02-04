<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Sustainability]].
 *
 * @see Sustainability
 */
class SustainabilityQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Sustainability[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Sustainability|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
