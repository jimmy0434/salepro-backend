<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Industries]].
 *
 * @see Industries
 */
class IndustriesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Industries[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Industries|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
