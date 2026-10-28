<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[CountryProfile]].
 *
 * @see CountryProfile
 */
class CountryProfileQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CountryProfile[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CountryProfile|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
