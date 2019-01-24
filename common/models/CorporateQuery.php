<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Corporate]].
 *
 * @see Corporate
 */
class CorporateQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Corporate[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Corporate|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
